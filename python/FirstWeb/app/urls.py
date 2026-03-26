from django.urls import path
from . import views


urlpatterns = [
    path('', views.index, name='index'),
    path('vote/<int:post_id>/', views.vote_on_post, name='vote_on_post'),
    path('leader/login/', views.leader_login, name='leader_login'),
    path('leader/logout/', views.leader_logout, name='leader_logout'),
    path('leader/dashboard/', views.leader_dashboard, name='leader_dashboard'),
    path('leader/posts/create/', views.leader_post_create, name='leader_post_create'),
    path('leader/posts/<int:post_id>/edit/', views.leader_post_edit, name='leader_post_edit'),
]
