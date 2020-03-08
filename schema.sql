INSERT INTO `users`(`id`, `created_at`, `updated_at`, `firstname`, `lastname`, `email`, `birthdate`, `phone`, `password`, `gender`, `api_key`) VALUES (1, '2020-03-08 17:28:28', '2020-03-08 17:28:37', 'John', 'doe', 'john@example.com', '1983-06-05', '123456789', '$2y$10$rusbnlpi16kUxyPL/j7vTumx8NSjUFEqTZVOZ5gjKPwZJR4ULHCvu', 'male', 'TWNvYU4zTlJHQWFmUXRKRzBVa2c0NE9INzhsTUZPSTdXdTN0Y2VPU2tmMDA1T3BWbktoa0FTYmlNRHYwTnIwZA==');
INSERT INTO `categories`(`id`, `created_at`, `updated_at`, `name`, `description`) VALUES (1, '2020-03-08 17:28:43', '2020-03-08 17:28:43', 'new category', 'desc');
INSERT INTO `categories`(`id`, `created_at`, `updated_at`, `name`, `description`) VALUES (3, '2020-03-08 17:30:36', '2020-03-08 17:30:36', 'home', 'home stuff');
INSERT INTO `lists`(`id`, `created_at`, `updated_at`, `user_id`, `date`, `name`, `description`) VALUES (1, '2020-03-08 17:30:50', '2020-03-08 17:30:50', 1, '2020-03-18 00:00:00', 'shoping list', 'Things to buy');
INSERT INTO `tasks`(`id`, `created_at`, `updated_at`, `category_id`, `list_id`, `date`, `status`, `name`, `description`) VALUES (1, '2020-03-08 17:31:47', '2020-03-08 17:31:47', 3, 1, '2020-03-18 00:00:00', 'Snoozed', 'Buy a dog food', 'This furry thing needs to eat');
