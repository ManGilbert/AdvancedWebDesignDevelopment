import datetime

from django.db import models
from django.utils import timezone


class Question(models.Model):
    STATUS_CHOICES = [
        ("draft", "Draft"),
        ("published", "Published"),
        ("closed", "Closed"),
    ]

    question_text = models.CharField(max_length=200)
    pub_date = models.DateTimeField("date published")
    status = models.CharField(max_length=20, choices=STATUS_CHOICES, default="draft")
    posted_by = models.CharField(max_length=120, default="ULK Poll Manager")

    class Meta:
        ordering = ["-pub_date"]

    def __str__(self):
        return self.question_text

    @property
    def total_votes(self):
        return sum(choice.votes for choice in self.choices.all())

    @property
    def is_open(self):
        return self.status == "published" and self.pub_date <= timezone.now()

    @property
    def lead_choice(self):
        return self.choices.order_by("-votes", "choice_text").first()

    @property
    def total_responses(self):
        return self.vote_records.count()

    def was_published_recently(self):
        now = timezone.now()
        return now - datetime.timedelta(days=1) <= self.pub_date <= now


Question.was_published_recently.admin_order_field = "pub_date"
Question.was_published_recently.boolean = True
Question.was_published_recently.short_description = "Published recently?"


class Choice(models.Model):
    question = models.ForeignKey(Question, on_delete=models.CASCADE, related_name="choices")
    choice_text = models.CharField(max_length=200)
    votes = models.IntegerField(default=0)

    class Meta:
        ordering = ["id"]

    def __str__(self):
        return self.choice_text


class VoteRecord(models.Model):
    question = models.ForeignKey(Question, on_delete=models.CASCADE, related_name="vote_records")
    choice = models.ForeignKey(Choice, on_delete=models.CASCADE, related_name="vote_records")
    student_name = models.CharField(max_length=120)
    registration_number = models.CharField(max_length=50)
    email = models.EmailField()
    voted_at = models.DateTimeField(auto_now_add=True)

    class Meta:
        ordering = ["-voted_at"]
        constraints = [
            models.UniqueConstraint(
                fields=["question", "registration_number"],
                name="unique_vote_per_question_and_registration_number",
            )
        ]

    def __str__(self):
        return f"{self.registration_number} - {self.question.question_text}"
