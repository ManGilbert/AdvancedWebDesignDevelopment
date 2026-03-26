from django.conf import settings
from django.contrib import messages
from django.contrib.auth import authenticate, login, logout
from django.contrib.auth.decorators import user_passes_test
from django.db.models import Count, Q
from django.http import HttpResponseForbidden
from django.shortcuts import get_object_or_404, redirect, render
from django.utils import timezone

from .forms import LeaderLoginForm, LeaderPostForm, VoteForm
from .models import LeaderPost, Vote


def is_poll_manager(user):
    return user.is_authenticated and user.is_superuser


def index(request):
    active_posts = (
        LeaderPost.objects.filter(status="published")
        .annotate(
            votes_for_a=Count("votes", filter=Q(votes__choice=Vote.CHOICE_A)),
            votes_for_b=Count("votes", filter=Q(votes__choice=Vote.CHOICE_B)),
        )
    )
    recent_posts = LeaderPost.objects.exclude(status="draft")[:5]
    context = {
        "active_posts": active_posts,
        "recent_posts": recent_posts,
    }
    return render(request, "index.html", context)


def vote_on_post(request, post_id):
    post = get_object_or_404(LeaderPost, pk=post_id, status="published")
    if request.method == "POST":
        form = VoteForm(request.POST, post=post)
        if form.is_valid():
            registration_number = form.cleaned_data["registration_number"]
            if Vote.objects.filter(post=post, registration_number=registration_number).exists():
                messages.error(request, "This registration number has already voted on this post.")
            else:
                vote = form.save(commit=False)
                vote.post = post
                vote.save()
                messages.success(request, "Your vote has been recorded successfully.")
        else:
            messages.error(request, "Please correct the form and try again.")
    return redirect("index")


def leader_login(request):
    if is_poll_manager(request.user):
        return redirect("leader_dashboard")

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
            return redirect("leader_dashboard")
        messages.error(request, "Invalid superuser credentials.")
    return render(request, "leader_login.html", {"form": form})


def leader_logout(request):
    logout(request)
    messages.success(request, "You have been logged out.")
    return redirect("leader_login")


@user_passes_test(is_poll_manager, login_url="leader_login")
def leader_dashboard(request):
    posts = (
        LeaderPost.objects.all()
        .annotate(
            votes_for_a=Count("votes", filter=Q(votes__choice=Vote.CHOICE_A)),
            votes_for_b=Count("votes", filter=Q(votes__choice=Vote.CHOICE_B)),
        )
    )
    return render(request, "leader_dashboard.html", {"posts": posts, "now": timezone.now()})


@user_passes_test(is_poll_manager, login_url="leader_login")
def leader_post_create(request):
    form = LeaderPostForm(request.POST or None, initial={"published_at": timezone.now()})
    if request.method == "POST" and form.is_valid():
        form.save()
        messages.success(request, "Leader post created successfully.")
        return redirect("leader_dashboard")
    return render(request, "leader_post_form.html", {"form": form, "page_title": "Create leader post"})


@user_passes_test(is_poll_manager, login_url="leader_login")
def leader_post_edit(request, post_id):
    post = get_object_or_404(LeaderPost, pk=post_id)
    form = LeaderPostForm(request.POST or None, instance=post)
    if request.method == "POST" and form.is_valid():
        form.save()
        messages.success(request, "Leader post updated successfully.")
        return redirect("leader_dashboard")
    return render(request, "leader_post_form.html", {"form": form, "page_title": "Edit leader post", "post": post})
