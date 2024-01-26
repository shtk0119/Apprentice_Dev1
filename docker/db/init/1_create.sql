-- データベース作成 すべての文字列を許可
CREATE DATABASE IF NOT EXISTS chodoii_task
DEFAULT CHARACTER SET utf8mb4
COLLATE utf8mb4_general_ci;

USE chodoii_task;

-- テーブル作成
CREATE TABLE `users`(
    `id` INT AUTO_INCREMENT PRIMARY KEY COMMENT 'ユーザーID',
    `email` VARCHAR(255) NOT NULL UNIQUE COMMENT 'ユーザーEmail',
    `name` VARCHAR(20) NOT NULL COMMENT '表示用ユーザーネーム',
    `pwd` VARCHAR(64) NOT NULL COMMENT 'パスワード',
    `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '作成日時',
    `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新日時'
);

CREATE TABLE `tasks`(
    `id` INT AUTO_INCREMENT PRIMARY KEY COMMENT 'タスクID',
    `name` VARCHAR(255) NOT NULL COMMENT 'タスク名',
    `user_id` INT NOT NULL COMMENT '外部キーusers ID',
    `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '作成日時',
    `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新日時',
    UNIQUE INDEX `unique_task_user_pair` (`user_id`,`name`)
);

CREATE TABLE `task_logs`(
    `id` INT AUTO_INCREMENT PRIMARY KEY COMMENT 'タスク実行記録ID',
    `time` TIME NOT NULL DEFAULT '00:00:00' COMMENT 'タスク実行時間の累計(１日)',
    `date` DATE NOT NULL COMMENT 'タスク登録日',
    `task_id` INT NOT NULL COMMENT '外部キーtasks ID',
    `user_id` INT NOT NULL COMMENT '外部キーusers ID',
    `delete_flag` INT NOT NULL DEFAULT 0 COMMENT '未実施:0, 完了:1',
    `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '作成日時',
    `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新日時',
    UNIQUE INDEX `unique_task_user_date_pair` (`task_id`, `user_id`, `date`)
);


CREATE TABLE `reports` (
    `id` INT AUTO_INCREMENT PRIMARY KEY COMMENT '日報ID',
    `text` TEXT NOT NULL COMMENT '日報テキスト',
    `user_id` INT NOT NULL COMMENT '外部キーusers ID',
    `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '作成日時',
    `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新日時',
    `date` DATE NOT NULL COMMENT '日報登録日',
    UNIQUE INDEX `unique_report_date` (`date`)
);


CREATE TABLE `time_reports`(
    `id` INT AUTO_INCREMENT PRIMARY KEY COMMENT 'タスク時間管理ID',
    `total_time` time NOT NULL DEFAULT '00:00:00' COMMENT '累計タスク実行時間',
    `avg_time` time NOT NULL DEFAULT '00:00:00' COMMENT '累計タスク平均時間',
    `task_id` INT NOT NULL COMMENT '外部キーtasks ID',
    `user_id` INT NOT NULL COMMENT '外部キーusers ID',
    `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '作成日時',
    `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新日時'
);

-- 外部キー制約
ALTER TABLE `reports`
ADD CONSTRAINT fk_reports_user
FOREIGN KEY (user_id)
    REFERENCES users(id)
    ON UPDATE CASCADE
    ON DELETE RESTRICT;

ALTER TABLE `tasks`
ADD CONSTRAINT fk_tasks_user
FOREIGN KEY (user_id)
    REFERENCES users(id)
    ON UPDATE CASCADE
    ON DELETE RESTRICT;

ALTER TABLE `time_reports`
ADD CONSTRAINT fk_time_reports_user
FOREIGN KEY (user_id)
    REFERENCES users(id)
    ON UPDATE CASCADE
    ON DELETE RESTRICT,
ADD CONSTRAINT fk_time_reports_task
FOREIGN KEY (task_id)
    REFERENCES tasks(id)
    ON UPDATE CASCADE
    ON DELETE RESTRICT;

ALTER TABLE `task_logs`
ADD CONSTRAINT fk_task_logs_user
FOREIGN KEY (user_id)
    REFERENCES users(id)
    ON UPDATE CASCADE
    ON DELETE RESTRICT,
ADD CONSTRAINT fk_task_logs_tasks
FOREIGN KEY (task_id)
    REFERENCES tasks(id)
    ON UPDATE CASCADE
    ON DELETE RESTRICT;

-- sample_data挿入順番
-- users => tasks => tasklogs => time_reports => reports

ALTER TABLE `users` auto_increment = 1;
-- ユーザーサンプルデータ
INSERT INTO `users` (`name`, `email`, `pwd`) VALUES
    ('shinagawa', 'shinagawa@example.com', 'pwd'),
    ('shigeta', 'shigeta@example.com', 'pwd'),
    ('hirose', 'hirose@example.com', 'pwd');

ALTER TABLE `tasks` auto_increment = 1;
-- タスクサンプルデータ
INSERT INTO `tasks` (`name`,`user_id`)
VALUES
    ('QUEST', 1),
    ('QUEST Advanced', 1),
    ('提出QUEST', 1),
    ('リファクタリング', 1),
    ('DB設計', 1),
    ('環境構築', 1),
    ('書籍学習', 1),
    ('YouTube学習', 1),
    ('Udemy学習', 1),
    ('Paiza', 1),
    ('standard QUEST', 2),
    ('Advanced QUEST', 2),
    ('提出QUEST', 2),
    ('リファクタリング', 2),
    ('QUEST復習', 2),
    ('環境構築', 2),
    ('技術ブログ作成', 2),
    ('動画学習', 2),
    ('PHPドキュメント学習', 2),
    ('AtCoder', 2),
    ('QUEST',3),
    ('アドバンスQUEST', 3),
    ('提出QUEST', 3),
    ('MTG', 3),
    ('QUEST復習', 3),
    ('QUEST振り返り', 3),
    ('ブログ作成', 3),
    ('動画学習', 3),
    ('JavaScriptドキュメント', 3),
    ('AtCoder', 3);

ALTER TABLE `task_logs` auto_increment = 1;
-- タスクログサンプルデータ
INSERT INTO `task_logs` (`time`, `date`, `task_id`, `user_id`)
VALUES
    ('02:30:00', '2024-01-23', 1, 1),
    ('01:45:00', '2024-01-23', 4, 1),
    ('02:10:00', '2024-01-24', 6, 1),
    ('02:00:00', '2024-01-23', 7, 1),
    ('02:20:00', '2024-01-23', 8, 1),
    ('00:55:00', '2024-01-24', 10, 1),
    ('03:15:00', '2024-01-23', 11, 2),
    ('02:45:00', '2024-01-23', 13, 2),
    ('01:30:00', '2024-01-23', 15, 2),
    ('00:45:00', '2024-01-23', 17, 2),
    ('01:00:00', '2024-01-23', 22, 3),
    ('01:20:00', '2024-01-24', 24, 3),
    ('01:10:00', '2024-01-23', 26, 3),
    ('00:50:00', '2024-01-23', 28, 3),
    ('02:25:00', '2024-01-24', 7, 1),
    ('02:05:00', '2024-01-24', 8, 1),
    ('03:00:00', '2024-01-24', 12, 2),
    ('01:40:00', '2024-01-24', 16, 2),
    ('00:48:00', '2024-01-24', 18, 2),
    ('01:35:00', '2024-01-24', 19, 2),
    ('01:15:00', '2024-01-24', 22, 3),
    ('01:25:00', '2024-01-24', 27, 3),
    ('02:55:00', '2024-01-25', 1, 1),
    ('01:18:00', '2024-01-25', 4, 1),
    ('02:15:00', '2024-01-25', 6, 1),
    ('02:40:00', '2024-01-25', 7, 1),
    ('00:58:00', '2024-01-25', 9, 1),
    ('02:50:00', '2024-01-25', 16, 2),
    ('01:55:00', '2024-01-25', 19, 2),
    ('01:22:00', '2024-01-25', 18, 2),
    ('03:05:00', '2024-01-25', 26, 3),
    ('01:30:00', '2024-01-25', 29, 3),
    ('02:18:00', '2024-01-26', 4, 1),
    ('02:00:00', '2024-01-26', 8, 1),
    ('00:52:00', '2024-01-26', 10, 1),
    ('02:48:00', '2024-01-26', 14, 2),
    ('02:35:00', '2024-01-26', 18, 2),
    ('00:42:00', '2024-01-26', 13, 2),
    ('01:32:00', '2024-01-26', 11, 2),
    ('01:28:00', '2024-01-26', 22, 3),
    ('01:12:00', '2024-01-26', 27, 3),
    ('02:22:00', '2024-01-27', 5, 1),
    ('02:25:00', '2024-01-27', 7, 1),
    ('02:12:00', '2024-01-27', 8, 1),
    ('00:58:00', '2024-01-27', 1, 1),
    ('02:55:00', '2024-01-27', 15, 2),
    ('01:40:00', '2024-01-27', 18, 2),
    ('00:46:00', '2024-01-27', 13, 2),
    ('01:08:00', '2024-01-27', 25, 3),
    ('01:18:00', '2024-01-27', 29, 3),
    ('01:20:00', '2024-01-27', 21, 3),
    ('03:00:00', '2024-01-28', 1, 1),
    ('01:25:00', '2024-01-28', 4, 1),
    ('02:05:00', '2024-01-28', 7, 1),
    ('02:30:00', '2024-01-28', 12, 2),
    ('01:48:00', '2024-01-28', 16, 2),
    ('01:15:00', '2024-01-28', 14, 2),
    ('01:38:00', '2024-01-28', 25, 3);

-- 日報サンプルデータ
ALTER TABLE `reports` auto_increment = 1;
INSERT INTO `reports` (`text`, `user_id`, `created_at`, `updated_at`, `date`)
VALUES
    ('今日の作業内容を報告します。', 1, '2023-12-15 10:00:00', '2023-12-15 10:00:00', '2023-12-15'),
    ('昨日の進捗と今日の予定を報告します。', 2, '2023-12-16 12:30:00', '2023-12-16 12:30:00', '2023-12-16'),
    ('新しいプロジェクトのスケジュールを作成しました。', 3, '2023-12-17 15:45:00', '2023-12-17 15:45:00', '2023-12-17'),
    ('プロトタイプの開発を進めました。', 1, '2023-12-18 11:00:00', '2023-12-18 11:00:00', '2023-12-18'),
    ('顧客との会議があり、要件を確認しました。', 2, '2023-12-19 14:30:00', '2023-12-19 14:30:00', '2023-12-19'),
    ('新しいデザインの提案を作成しました。', 3, '2023-12-20 17:15:00', '2023-12-20 17:15:00', '2023-12-20'),
    ('今週の進捗と次週の計画をまとめました。', 1, '2023-12-21 09:45:00', '2023-12-21 09:45:00', '2023-12-21'),
    ('プロジェクトのバグ修正を行いました。', 2, '2023-12-22 13:20:00', '2023-12-22 13:20:00', '2023-12-22'),
    ('新しい機能の設計を開始しました。', 3, '2023-12-23 16:55:00', '2023-12-23 16:55:00', '2023-12-23'),
    ('週末の準備をしました。', 1, '2023-12-24 08:30:00', '2023-12-24 08:30:00', '2023-12-24');

ALTER TABLE `time_reports` auto_increment = 1;
-- 時間管理サンプルデータ取得クエリ
INSERT INTO `time_reports` (`total_time`, `avg_time`, `task_id`, `user_id`)
SELECT
    SEC_TO_TIME(SUM(TIME_TO_SEC(`time`))) AS `total_time`,  -- 累計タスク実行時間
    SEC_TO_TIME(AVG(TIME_TO_SEC(`time`))) AS `avg_time`,    -- 平均タスク実行時間
    `task_id`,
    `user_id`
FROM
    `task_logs`
GROUP BY
    `task_id`, `user_id`;
