from django.urls import path

from . import views

app_name = "polls"

urlpatterns = [
    path("", views.index, name="index"),
    path("<int:question_id>/", views.detail, name="detail"),
    path("<int:question_id>/results/", views.results, name="results"),
    path("<int:question_id>/vote/", views.vote, name="vote"),
    path("leader/login/", views.leader_login, name="leader_login"),
    path("leader/logout/", views.leader_logout, name="leader_logout"),
    path("leader/dashboard/", views.leader_dashboard, name="leader_dashboard"),
    path("leader/polls/create/", views.leader_question_create, name="leader_question_create"),
    path("leader/polls/<int:question_id>/edit/", views.leader_question_edit, name="leader_question_edit"),
]
