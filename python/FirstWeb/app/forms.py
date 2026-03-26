from django import forms
from django.forms import ModelForm, inlineformset_factory

from .models import Choice, Question


class BootstrapFormMixin:
    def apply_bootstrap(self):
        for field in self.fields.values():
            widget = field.widget
            if isinstance(widget, (forms.RadioSelect, forms.CheckboxInput)):
                widget.attrs["class"] = "form-check-input"
            else:
                existing = widget.attrs.get("class", "")
                widget.attrs["class"] = f"{existing} form-control".strip()


class LeaderLoginForm(BootstrapFormMixin, forms.Form):
    username = forms.CharField(
        max_length=150,
        widget=forms.TextInput(attrs={"placeholder": "Enter superuser username"}),
    )
    password = forms.CharField(
        max_length=100,
        widget=forms.PasswordInput(attrs={"placeholder": "Enter superuser password"}),
    )

    def __init__(self, *args, **kwargs):
        super().__init__(*args, **kwargs)
        self.apply_bootstrap()


class QuestionForm(BootstrapFormMixin, forms.ModelForm):
    class Meta:
        model = Question
        fields = ["question_text", "pub_date", "status", "posted_by"]
        widgets = {
            "pub_date": forms.DateTimeInput(attrs={"type": "datetime-local"}),
        }

    def __init__(self, *args, **kwargs):
        super().__init__(*args, **kwargs)
        self.apply_bootstrap()
        pub_date = self.initial.get("pub_date") or getattr(self.instance, "pub_date", None)
        if pub_date:
            self.initial["pub_date"] = pub_date.strftime("%Y-%m-%dT%H:%M")


class ChoiceForm(BootstrapFormMixin, ModelForm):
    class Meta:
        model = Choice
        fields = ("choice_text",)

    def __init__(self, *args, **kwargs):
        super().__init__(*args, **kwargs)
        self.apply_bootstrap()


ChoiceFormSet = inlineformset_factory(
    Question,
    Choice,
    form=ChoiceForm,
    extra=2,
    can_delete=True,
    min_num=2,
    validate_min=True,
)


class VoteMetadataForm(BootstrapFormMixin, forms.Form):
    student_name = forms.CharField(max_length=120)
    registration_number = forms.CharField(max_length=50)
    email = forms.EmailField()
    choice = forms.ChoiceField(widget=forms.RadioSelect)

    def __init__(self, *args, **kwargs):
        question = kwargs.pop("question")
        super().__init__(*args, **kwargs)
        self.fields["choice"].choices = [(choice.id, choice.choice_text) for choice in question.choices.all()]
        self.apply_bootstrap()
