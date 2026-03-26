from django.db import migrations, models
import django.db.models.deletion
import django.utils.timezone


class Migration(migrations.Migration):

    initial = True

    dependencies = []

    operations = [
        migrations.CreateModel(
            name="LeaderPost",
            fields=[
                ("id", models.BigAutoField(auto_created=True, primary_key=True, serialize=False, verbose_name="ID")),
                ("title", models.CharField(max_length=200)),
                ("summary", models.CharField(max_length=255)),
                ("content", models.TextField()),
                ("option_a", models.CharField(default="Approve", max_length=120)),
                ("option_b", models.CharField(default="Reject", max_length=120)),
                ("status", models.CharField(choices=[("draft", "Draft"), ("published", "Published"), ("closed", "Closed")], default="draft", max_length=20)),
                ("posted_by", models.CharField(default="ULK Student Leader", max_length=120)),
                ("published_at", models.DateTimeField(default=django.utils.timezone.now)),
                ("created_at", models.DateTimeField(auto_now_add=True)),
                ("updated_at", models.DateTimeField(auto_now=True)),
            ],
            options={"ordering": ["-published_at", "-created_at"]},
        ),
        migrations.CreateModel(
            name="Vote",
            fields=[
                ("id", models.BigAutoField(auto_created=True, primary_key=True, serialize=False, verbose_name="ID")),
                ("student_name", models.CharField(max_length=120)),
                ("registration_number", models.CharField(max_length=50)),
                ("email", models.EmailField(max_length=254)),
                ("choice", models.CharField(choices=[("A", "Option A"), ("B", "Option B")], max_length=1)),
                ("voted_at", models.DateTimeField(auto_now_add=True)),
                ("post", models.ForeignKey(on_delete=django.db.models.deletion.CASCADE, related_name="votes", to="app.leaderpost")),
            ],
            options={"ordering": ["-voted_at"]},
        ),
        migrations.AddConstraint(
            model_name="vote",
            constraint=models.UniqueConstraint(fields=("post", "registration_number"), name="unique_vote_per_post_and_registration_number"),
        ),
    ]
