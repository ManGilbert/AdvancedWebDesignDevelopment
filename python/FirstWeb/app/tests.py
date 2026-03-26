from django.contrib.auth import get_user_model
from django.test import TestCase
from django.urls import reverse
from django.utils import timezone

from .models import Choice, Question, VoteRecord


class VotingPortalTests(TestCase):
    def setUp(self):
        self.superuser = get_user_model().objects.create_superuser(
            username="admin",
            email="admin@example.com",
            password="StrongPass123!",
        )
        self.question = Question.objects.create(
            question_text="Elect class representative",
            status="published",
            posted_by="Dean of Students",
            pub_date=timezone.now(),
        )
        self.choice_a = Choice.objects.create(question=self.question, choice_text="Candidate A")
        self.choice_b = Choice.objects.create(question=self.question, choice_text="Candidate B")

    def test_index_shows_published_question(self):
        response = self.client.get(reverse("polls:index"))
        self.assertContains(response, "Elect class representative")

    def test_student_cannot_vote_twice_on_same_question(self):
        VoteRecord.objects.create(
            question=self.question,
            choice=self.choice_a,
            student_name="Jane Doe",
            registration_number="ULK001",
            email="jane@example.com",
        )
        self.choice_a.votes = 1
        self.choice_a.save()

        response = self.client.post(
            reverse("polls:vote", args=[self.question.id]),
            {
                "student_name": "Jane Doe",
                "registration_number": "ULK001",
                "email": "jane@example.com",
                "choice": self.choice_b.id,
            },
        )

        self.assertEqual(VoteRecord.objects.filter(question=self.question, registration_number="ULK001").count(), 1)
        self.assertContains(response, "already voted")

    def test_leader_login_allows_dashboard_access(self):
        login_response = self.client.post(
            reverse("polls:leader_login"),
            {"username": "admin", "password": "StrongPass123!"},
            follow=True,
        )

        self.assertRedirects(login_response, reverse("polls:leader_dashboard"))
        dashboard_response = self.client.get(reverse("polls:leader_dashboard"))
        self.assertEqual(dashboard_response.status_code, 200)

    def test_non_superuser_cannot_access_dashboard(self):
        user = get_user_model().objects.create_user(
            username="student",
            email="student@example.com",
            password="StudentPass123!",
        )
        self.client.force_login(user)
        response = self.client.get(reverse("polls:leader_dashboard"))
        self.assertEqual(response.status_code, 302)
