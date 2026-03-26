from django.contrib import admin
from .models import LeaderPost, Vote


@admin.register(LeaderPost)
class LeaderPostAdmin(admin.ModelAdmin):
    list_display = ("title", "posted_by", "status", "published_at", "total_votes")
    list_filter = ("status", "published_at")
    search_fields = ("title", "summary", "posted_by")


@admin.register(Vote)
class VoteAdmin(admin.ModelAdmin):
    list_display = ("post", "student_name", "registration_number", "email", "choice", "voted_at")
    list_filter = ("choice", "voted_at")
    search_fields = ("student_name", "registration_number", "email", "post__title")
