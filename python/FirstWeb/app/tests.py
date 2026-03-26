from django.test import TestCase
from django.urls import reverse
from django.utils import timezone
from django.contrib.auth import get_user_model

from .models import LeaderPost, Vote


class VotingPortalTests(TestCase):
    def setUp(self):
        self.superuser = get_user_model().objects.create_superuser(
            username="admin",
            email="admin@example.com",
            password="StrongPass123!",
        )
        self.post = LeaderPost.objects.create(
            title="Elect class representative",
            summary="Choose the student leader for the next semester.",
            content="Students are invited to vote for the next class representative.",
            option_a="Candidate A",
            option_b="Candidate B",
            status="published",
            published_at=timezone.now(),
        )

    def test_student_cannot_vote_twice_on_same_post(self):
        Vote.objects.create(
            post=self.post,
            student_name="Jane Doe",
            registration_number="ULK001",
            email="jane@example.com",
            choice=Vote.CHOICE_A,
        )

        response = self.client.post(
            reverse("vote_on_post", args=[self.post.id]),
            {
                "student_name": "Jane Doe",
                "registration_number": "ULK001",
                "email": "jane@example.com",
                "choice": Vote.CHOICE_B,
            },
            follow=True,
        )

        self.assertEqual(Vote.objects.filter(post=self.post, registration_number="ULK001").count(), 1)
        self.assertContains(response, "already voted")

    def test_leader_login_allows_dashboard_access(self):
        login_response = self.client.post(
            reverse("leader_login"),
            {"username": "admin", "password": "StrongPass123!"},
            follow=True,
        )

        self.assertRedirects(login_response, reverse("leader_dashboard"))
        dashboard_response = self.client.get(reverse("leader_dashboard"))
        self.assertEqual(dashboard_response.status_code, 200)

    def test_non_superuser_cannot_access_dashboard(self):
        user = get_user_model().objects.create_user(
            username="student",
            email="student@example.com",
            password="StudentPass123!",
        )
        self.client.force_login(user)
        response = self.client.get(reverse("leader_dashboard"))
        self.assertEqual(response.status_code, 302)

# Create your tests here.
