from django.db import migrations, models
import django.db.models.deletion


class Migration(migrations.Migration):
    dependencies = [
        ("app", "0001_initial"),
    ]

    operations = [
        migrations.DeleteModel(
            name="Vote",
        ),
        migrations.DeleteModel(
            name="LeaderPost",
        ),
        migrations.CreateModel(
            name="Question",
            fields=[
                ("id", models.BigAutoField(auto_created=True, primary_key=True, serialize=False, verbose_name="ID")),
                ("question_text", models.CharField(max_length=200)),
                ("pub_date", models.DateTimeField(verbose_name="date published")),
                ("status", models.CharField(choices=[("draft", "Draft"), ("published", "Published"), ("closed", "Closed")], default="draft", max_length=20)),
                ("posted_by", models.CharField(default="ULK Poll Manager", max_length=120)),
            ],
            options={"ordering": ["-pub_date"]},
        ),
        migrations.CreateModel(
            name="Choice",
            fields=[
                ("id", models.BigAutoField(auto_created=True, primary_key=True, serialize=False, verbose_name="ID")),
                ("choice_text", models.CharField(max_length=200)),
                ("votes", models.IntegerField(default=0)),
                ("question", models.ForeignKey(on_delete=django.db.models.deletion.CASCADE, related_name="choices", to="app.question")),
            ],
            options={"ordering": ["id"]},
        ),
        migrations.CreateModel(
            name="VoteRecord",
            fields=[
                ("id", models.BigAutoField(auto_created=True, primary_key=True, serialize=False, verbose_name="ID")),
                ("student_name", models.CharField(max_length=120)),
                ("registration_number", models.CharField(max_length=50)),
                ("email", models.EmailField(max_length=254)),
                ("voted_at", models.DateTimeField(auto_now_add=True)),
                ("choice", models.ForeignKey(on_delete=django.db.models.deletion.CASCADE, related_name="vote_records", to="app.choice")),
                ("question", models.ForeignKey(on_delete=django.db.models.deletion.CASCADE, related_name="vote_records", to="app.question")),
            ],
            options={"ordering": ["-voted_at"]},
        ),
        migrations.AddConstraint(
            model_name="voterecord",
            constraint=models.UniqueConstraint(fields=("question", "registration_number"), name="unique_vote_per_question_and_registration_number"),
        ),
    ]
