SELECT article_id FROM articles ORDER BY LOG10( ABS(upvotes-downvotes) + 1) * SIGN(upvotes - downvotes) + (UNIX_TIMESTAMP(article_date) / 3000) DESC LIMIT 100;