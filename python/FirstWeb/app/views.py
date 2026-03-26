from django.contrib import messages
from django.contrib.auth import authenticate, login, logout
from django.contrib.auth.decorators import user_passes_test
from django.db.models import Sum
from django.shortcuts import get_object_or_404, redirect, render
from django.utils import timezone

from .forms import ChoiceFormSet, LeaderLoginForm, QuestionForm, VoteMetadataForm
from .models import Question, VoteRecord


def is_poll_manager(user):
    return user.is_authenticated and user.is_superuser


def get_latest_question_list():
    return Question.objects.filter(
        status="published",
        pub_date__lte=timezone.now(),
    ).order_by("-pub_date")[:5]


def index(request):
    latest_question_list = get_latest_question_list()
    return render(
        request,
        "polls/index.html",
        {
            "latest_question_list": latest_question_list,
            "latest_announcement": latest_question_list[0] if latest_question_list else None,
        },
    )


def detail(request, question_id):
    question = get_object_or_404(
        Question,
        pk=question_id,
        status="published",
        pub_date__lte=timezone.now(),
    )
    form = VoteMetadataForm(question=question)
    return render(request, "polls/detail.html", {"question": question, "form": form})


def results(request, question_id):
    question = get_object_or_404(Question, pk=question_id)
    return render(request, "polls/results.html", {"question": question})


def vote(request, question_id):
    question = get_object_or_404(
        Question,
        pk=question_id,
        status="published",
        pub_date__lte=timezone.now(),
    )
    form = VoteMetadataForm(request.POST or None, question=question)
    if request.method != "POST":
        return redirect("polls:detail", question_id=question.id)

    if not form.is_valid():
        return render(
            request,
            "polls/detail.html",
            {"question": question, "form": form, "error_message": "Please complete all voting fields."},
        )

    registration_number = form.cleaned_data["registration_number"]
    if VoteRecord.objects.filter(question=question, registration_number=registration_number).exists():
        return render(
            request,
            "polls/detail.html",
            {
                "question": question,
                "form": form,
                "error_message": "This registration number has already voted on this poll.",
            },
        )

    selected_choice = get_object_or_404(question.choices, pk=form.cleaned_data["choice"])
    selected_choice.votes += 1
    selected_choice.save()
    VoteRecord.objects.create(
        question=question,
        choice=selected_choice,
        student_name=form.cleaned_data["student_name"],
        registration_number=registration_number,
        email=form.cleaned_data["email"],
    )
    messages.success(request, "Your vote has been recorded successfully.")
    return redirect("polls:results", question_id=question.id)


def leader_login(request):
    if is_poll_manager(request.user):
        return redirect("polls:leader_dashboard")

    form = LeaderLoginForm(request.POST or None)
    if request.method == "POST" and form.is_valid():
        user = authenticate(
            request,
            username=form.cleaned_data["username"],
            password=form.cleaned_data["password"],
        )
        if user and user.is_superuser:
            login(request, user)
            messages.success(request, "Leader access granted.")
            return redirect("polls:leader_dashboard")
        messages.error(request, "Invalid superuser credentials.")
    return render(request, "polls/leader_login.html", {"form": form})


def leader_logout(request):
    logout(request)
    messages.success(request, "You have been logged out.")
    return redirect("polls:leader_login")


@user_passes_test(is_poll_manager, login_url="/leader/login/")
def leader_dashboard(request):
    questions = Question.objects.all().annotate(total_vote_count=Sum("choices__votes"))
    return render(
        request,
        "polls/leader_dashboard.html",
        {"questions": questions, "now": timezone.now()},
    )


@user_passes_test(is_poll_manager, login_url="/leader/login/")
def leader_question_create(request):
    question = Question(pub_date=timezone.now())
    form = QuestionForm(request.POST or None, instance=question)
    formset = ChoiceFormSet(request.POST or None, instance=question, prefix="choices")
    if request.method == "POST" and form.is_valid() and formset.is_valid():
        question = form.save()
        formset.instance = question
        formset.save()
        messages.success(request, "Poll created successfully.")
        return redirect("polls:leader_dashboard")
    return render(
        request,
        "polls/leader_question_form.html",
        {"form": form, "formset": formset, "page_title": "Create poll"},
    )


@user_passes_test(is_poll_manager, login_url="/leader/login/")
def leader_question_edit(request, question_id):
    question = get_object_or_404(Question, pk=question_id)
    form = QuestionForm(request.POST or None, instance=question)
    formset = ChoiceFormSet(request.POST or None, instance=question, prefix="choices")
    if request.method == "POST" and form.is_valid() and formset.is_valid():
        question = form.save()
        formset.instance = question
        formset.save()
        messages.success(request, "Poll updated successfully.")
        return redirect("polls:leader_dashboard")
    return render(
        request,
        "polls/leader_question_form.html",
        {"form": form, "formset": formset, "page_title": "Edit poll", "question": question},
    )
