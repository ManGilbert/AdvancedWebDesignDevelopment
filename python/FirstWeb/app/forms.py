from django import forms

from .models import LeaderPost, Vote


class LeaderLoginForm(forms.Form):
    username = forms.CharField(
        max_length=150,
        widget=forms.TextInput(attrs={"placeholder": "Enter superuser username"}),
    )
    password = forms.CharField(
        max_length=100,
        widget=forms.PasswordInput(attrs={"placeholder": "Enter superuser password"}),
    )


class LeaderPostForm(forms.ModelForm):
    class Meta:
        model = LeaderPost
        fields = [
            "title",
            "summary",
            "content",
            "option_a",
            "option_b",
            "status",
            "posted_by",
            "published_at",
        ]
        widgets = {
            "content": forms.Textarea(attrs={"rows": 6}),
            "published_at": forms.DateTimeInput(attrs={"type": "datetime-local"}),
        }

    def __init__(self, *args, **kwargs):
        super().__init__(*args, **kwargs)
        published_at = self.initial.get("published_at") or getattr(self.instance, "published_at", None)
        if published_at:
            self.initial["published_at"] = published_at.strftime("%Y-%m-%dT%H:%M")


class VoteForm(forms.ModelForm):
    class Meta:
        model = Vote
        fields = ["student_name", "registration_number", "email", "choice"]
        widgets = {
            "choice": forms.RadioSelect,
        }

    def __init__(self, *args, **kwargs):
        post = kwargs.pop("post")
        super().__init__(*args, **kwargs)
        self.fields["choice"].choices = [
            (Vote.CHOICE_A, post.option_a),
            (Vote.CHOICE_B, post.option_b),
        ]
