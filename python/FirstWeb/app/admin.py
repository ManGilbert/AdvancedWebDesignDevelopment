from django.contrib import admin

from .models import Choice, Question, VoteRecord


class ChoiceInline(admin.TabularInline):
    model = Choice
    extra = 2


@admin.register(Question)
class QuestionAdmin(admin.ModelAdmin):
    fieldsets = [
        (None, {"fields": ["question_text"]}),
        ("Publication", {"fields": ["pub_date", "status", "posted_by"]}),
    ]
    inlines = [ChoiceInline]
    list_display = ("question_text", "pub_date", "status", "posted_by", "was_published_recently")
    list_filter = ["pub_date", "status"]
    search_fields = ["question_text", "posted_by"]


@admin.register(VoteRecord)
class VoteRecordAdmin(admin.ModelAdmin):
    list_display = ("question", "choice", "student_name", "registration_number", "email", "voted_at")
    list_filter = ("voted_at",)
    search_fields = ("student_name", "registration_number", "email", "question__question_text")
