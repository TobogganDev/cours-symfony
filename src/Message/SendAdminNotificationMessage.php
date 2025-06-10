<?php


namespace App\Message;

final class SendAdminNotificationMessage
{
    public function __construct(
        private int $articleId,
        private string $articleTitle,
        private string $authorEmail
    ) {
    }

    public function getArticleId(): int
    {
        return $this->articleId;
    }

    public function getArticleTitle(): string
    {
        return $this->articleTitle;
    }

    public function getAuthorEmail(): string
    {
        return $this->authorEmail;
    }
}
