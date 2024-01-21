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
    `time` time NOT NULL DEFAULT '00:00:00' COMMENT 'タスク実行時間の累計(１日)',
    `task_id` INT NOT NULL COMMENT '外部キーtasks ID',
    `user_id` INT NOT NULL COMMENT '外部キーusers ID',
    `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '作成日時',
    `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新日時'
);

CREATE TABLE `reports`(
    `id` INT AUTO_INCREMENT PRIMARY KEY COMMENT '日報ID',
    `text` TEXT NOT NULL COMMENT '日報テキスト',
    `user_id` INT NOT NULL COMMENT '外部キーusers ID',
    `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '作成日時',
    `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新日時'
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

CREATE TABLE `daily_tasks`(
    `id` INT AUTO_INCREMENT PRIMARY KEY COMMENT '日別タスクID',
    `task_id` INT NOT NULL COMMENT '外部キーtasks ID',
    `user_id` INT NOT NULL COMMENT '外部キーusers ID',
    `date` DATE NOT NULL COMMENT 'タスク登録日',
    `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '作成日時'
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

ALTER TABLE `daily_tasks`
ADD CONSTRAINT fk_daily_tasks_user
FOREIGN KEY (user_id)
    REFERENCES users(id)
    ON UPDATE CASCADE
    ON DELETE RESTRICT,
ADD CONSTRAINT fk_daily_tasks_task
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
    ('QUEST','1'),
    ('QUEST Advanced','1'),
    ('提出QUEST','1'),
    ('リファクタリング','1'),
    ('DB設計','1'),
    ('環境構築','1'),
    ('書籍学習','1'),
    ('YouTube学習','1'),
    ('Udemy学習','1'),
    ('Paiza','1'),
    ('AtCoder', '1'),
    ('技術ブログ', '1'),
    ('standard QUEST','2'),
    ('Advanced QUEST','2'),
    ('提出QUEST','2'),
    ('リファクタリング','2'),
    ('QUEST復習','2'),
    ('環境構築','2'),
    ('技術ブログ作成','2'),
    ('動画学習','2'),
    ('PHPドキュメント学習','2'),
    ('AtCoder', '2'),
    ('チームMTG', '2'),
    ('QUEST','3'),
    ('アドバンスQUEST','3'),
    ('提出QUEST','3'),
    ('MTG','3'),
    ('QUEST復習','3'),
    ('QUEST振り返り','3'),
    ('ブログ作成','3'),
    ('動画学習','3'),
    ('JavaScriptドキュメント','3'),
    ('AtCoder', '3'),
    ('progate', '3');

ALTER TABLE `task_logs` auto_increment = 1;
-- タスクログサンプルデータ
INSERT INTO `task_logs` (`time`, `task_id`, `user_id`)
VALUES
    ('02:30:00', 1, 1),
    ('01:45:00', 4, 1),
    ('00:45:00', 13, 2),
    ('03:15:00', 2, 2),
    ('01:00:00', 5, 3),
    ('02:00:00', 7, 1),
    ('01:30:00', 10, 2),
    ('00:50:00', 15, 3),
    ('02:20:00', 8, 1),
    ('01:10:00', 11, 3),
    ('02:45:00', 3, 2),
    ('01:20:00', 9, 3),
    ('00:55:00', 12, 1),
    ('02:10:00', 6, 1),
    ('01:35:00', 14, 2),
    ('03:00:00', 2, 2),
    ('01:15:00', 5, 3),
    ('02:25:00', 7, 1),
    ('01:40:00', 10, 2),
    ('00:48:00', 13, 2),
    ('02:05:00', 8, 1),
    ('01:25:00', 11, 3),
    ('02:50:00', 3, 2),
    ('01:30:00', 9, 3),
    ('00:58:00', 12, 1),
    ('02:15:00', 6, 1),
    ('01:22:00', 14, 2),
    ('02:55:00', 1, 1),
    ('01:18:00', 4, 1),
    ('03:05:00', 5, 3),
    ('02:40:00', 7, 1),
    ('01:55:00', 10, 2),
    ('00:42:00', 13, 2),
    ('02:00:00', 8, 1),
    ('01:12:00', 11, 3),
    ('02:35:00', 3, 2),
    ('01:28:00', 9, 3),
    ('00:52:00', 12, 1),
    ('02:18:00', 6, 1),
    ('01:32:00', 14, 2),
    ('02:48:00', 2, 2),
    ('01:08:00', 5, 3),
    ('02:25:00', 7, 1),
    ('01:40:00', 10, 2),
    ('00:46:00', 13, 2),
    ('02:12:00', 8, 1),
    ('01:20:00', 11, 3),
    ('02:55:00', 3, 2),
    ('01:18:00', 9, 3),
    ('00:58:00', 12, 1),
    ('02:22:00', 6, 1),
    ('01:15:00', 14, 2),
    ('03:00:00', 1, 1),
    ('01:25:00', 4, 1),
    ('02:30:00', 2, 2),
    ('01:38:00', 5, 3),
    ('02:05:00', 7, 1),
    ('01:48:00', 10, 2);

-- 日報サンプルデータ
ALTER TABLE `reports` auto_increment = 1;
INSERT INTO `reports` (`text`, `user_id`, `created_at`)
VALUES
    ('今日の進捗は良好です。', 1, '2024-01-01 08:00:00'),
    ('新しいプロジェクトに取り組んでいます。', 2, '2024-01-02 10:30:00'),
    ('ミーティングがありました。', 3, '2024-01-03 13:45:00'),
    ('バグの修正が完了しました。', 1, '2024-01-04 15:20:00'),
    ('デザインの提案を進めています。', 2, '2024-01-05 09:55:00'),
    ('今月の目標を達成しました。', 3, '2024-01-06 11:10:00'),
    ('新機能の開発がスタートしました。', 1, '2024-01-07 14:30:00'),
    ('プレゼン資料の作成中です。', 2, '2024-01-08 16:45:00'),
    ('重要なクライアントとの会議が予定されています。', 3, '2024-01-09 08:30:00'),
    ('プロジェクトの進捗レビューが行われました。', 1, '2024-01-10 10:15:00'),
    ('新規提案を検討中です。', 2, '2024-01-11 12:40:00'),
    ('テストフェーズに入りました。', 3, '2024-01-12 14:05:00'),
    ('今日の会議は順調でした。', 1, '2024-01-13 09:30:00'),
    ('新しいタスクの計画を立てています。', 2, '2024-01-14 11:45:00'),
    ('プロジェクトの進捗報告をしました。', 3, '2024-01-15 13:20:00'),
    ('デバッグ作業が進行中です。', 1, '2024-01-16 15:05:00'),
    ('クライアントとの打ち合わせがありました。', 2, '2024-01-17 17:30:00'),
    ('新機能のデザインを開始しました。', 3, '2024-02-01 10:00:00'),
    ('本番環境へのデプロイが完了しました。', 1, '2024-02-02 14:15:00'),
    ('プロジェクトメンバーとのワークショップを開催しました。', 2, '2024-02-03 16:40:00'),
    ('最終的なテストを実施中です。', 3, '2024-02-04 09:20:00'),
    ('提案された改善点を実装しています。', 1, '2024-02-05 11:35:00'),
    ('新しいバージョンのリリースが近づいています。', 2, '2024-02-06 13:50:00'),
    ('週次レポートを作成しています。', 3, '2024-02-07 15:15:00'),
    ('プロジェクトの進捗報告をしました。', 1, '2024-02-08 09:45:00'),
    ('新機能の開発が完了しました。', 2, '2024-02-09 12:00:00'),
    ('プロジェクトの締めくくりミーティングを開催しました。', 3, '2024-02-10 14:25:00'),
    ('今月の成果を振り返りました。', 1, '2024-03-01 11:30:00'),
    ('新しいプロジェクトに参加しました。', 2, '2024-03-02 13:45:00'),
    ('提案された改善点を実装しています。', 3, '2024-03-03 15:10:00'),
    ('進行中のプロジェクトの課題解決に取り組んでいます。', 1, '2024-03-04 09:50:00'),
    ('新しいデザイン案を検討しています。', 2, '2024-03-05 12:05:00'),
    ('最終的なテストを実施中です。', 3, '2024-03-06 14:20:00'),
    ('プロジェクトメンバーとのワークショップを開催しました。', 1, '2024-03-07 16:45:00'),
    ('提案された改善点を実装しています。', 2, '2024-03-08 10:15:00'),
    ('新しいバージョンのリリースが近づいています。', 3, '2024-03-09 12:30:00'),
    ('週次レポートを作成しています。', 1, '2024-03-10 14:55:00');

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

INSERT INTO `daily_tasks` (`user_id`, `task_id`, `date`)
VALUES
    (1, 2, "2024-01-21"),
    (1, 5, "2024-01-21"),
    (1, 3, "2024-01-21"),
    (1, 7, "2024-01-21"),
    (1, 1, "2024-01-21"),
    (1, 8, "2024-01-21");