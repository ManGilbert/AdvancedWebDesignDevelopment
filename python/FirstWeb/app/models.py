from django.db import models
from django.utils import timezone


class LeaderPost(models.Model):
    STATUS_CHOICES = [
        ("draft", "Draft"),
        ("published", "Published"),
        ("closed", "Closed"),
    ]

    title = models.CharField(max_length=200)
    summary = models.CharField(max_length=255)
    content = models.TextField()
    option_a = models.CharField(max_length=120, default="Approve")
    option_b = models.CharField(max_length=120, default="Reject")
    status = models.CharField(max_length=20, choices=STATUS_CHOICES, default="draft")
    posted_by = models.CharField(max_length=120, default="ULK Student Leader")
    published_at = models.DateTimeField(default=timezone.now)
    created_at = models.DateTimeField(auto_now_add=True)
    updated_at = models.DateTimeField(auto_now=True)

    class Meta:
        ordering = ["-published_at", "-created_at"]

    def __str__(self):
        return self.title

    @property
    def is_open(self):
        return self.status == "published"

    @property
    def total_votes(self):
        return self.votes.count()


class Vote(models.Model):
    CHOICE_A = "A"
    CHOICE_B = "B"
    CHOICE_CHOICES = [
        (CHOICE_A, "Option A"),
        (CHOICE_B, "Option B"),
    ]

    post = models.ForeignKey(LeaderPost, on_delete=models.CASCADE, related_name="votes")
    student_name = models.CharField(max_length=120)
    registration_number = models.CharField(max_length=50)
    email = models.EmailField()
    choice = models.CharField(max_length=1, choices=CHOICE_CHOICES)
    voted_at = models.DateTimeField(auto_now_add=True)

    class Meta:
        ordering = ["-voted_at"]
        constraints = [
            models.UniqueConstraint(
                fields=["post", "registration_number"],
                name="unique_vote_per_post_and_registration_number",
            )
        ]

    def __str__(self):
        return f"{self.registration_number} - {self.post.title}"
