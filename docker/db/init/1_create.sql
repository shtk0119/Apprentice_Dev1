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
    UNIQUE INDEX `unique_report_date_pair` (`date`, `user_id`)
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
    -- ユーザーID 1
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
    -- ユーザーID 2
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
    -- ユーザーID 3
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
    -- 26日
    ('02:18:00', '2024-01-26', 4, 1),
    ('02:00:00', '2024-01-26', 8, 1),
    ('00:52:00', '2024-01-26', 10, 1),
    ('02:48:00', '2024-01-26', 14, 2),
    ('02:35:00', '2024-01-26', 18, 2),
    ('00:42:00', '2024-01-26', 13, 2),
    ('01:32:00', '2024-01-26', 11, 2),
    ('01:28:00', '2024-01-26', 22, 3),
    ('01:12:00', '2024-01-26', 27, 3),
    -- 27日
    ('02:22:00', '2024-01-27', 5, 1),
    ('02:25:00', '2024-01-27', 7, 1),
    ('02:12:00', '2024-01-27', 8, 1),
    ('00:58:00', '2024-01-27', 1, 1),
    ('02:55:00', '2024-01-27', 15, 2),
    ('01:40:00', '2024-01-27', 18, 2),
    ('00:46:00', '2024-01-27', 13, 2),
    ('01:08:00', '2024-01-27', 25, 3),
    ('01:18:00', '2024-01-27', 29, 3),
    ('01:20:00', '2024-01-27', 21, 3);
    -- 28日
    -- ('03:00:00', '2024-01-28', 1, 1),
    -- ('01:25:00', '2024-01-28', 4, 1),
    -- ('02:05:00', '2024-01-28', 7, 1),
    -- ('02:30:00', '2024-01-28', 12, 2),
    -- ('01:48:00', '2024-01-28', 16, 2),
    -- ('01:15:00', '2024-01-28', 14, 2),
    -- ('01:38:00', '2024-01-28', 25, 3);

-- 日報サンプルデータ
ALTER TABLE `reports` auto_increment = 1;
INSERT INTO `reports` (`text`, `user_id`, `created_at`, `updated_at`, `date`)
VALUES
    -- 26日
    ('今日はチーム開発での残りの機能やバグの修正を主に行いました。バグが起きた際は原因の箇所はある程度わかるけれど修正する方法がわからないずにどうしても時間がかかってしまうのは仕方がないかなと思いつつももっと早く解決できるようにしていきたいなと思いました。チームメンバーのコードを見ることで勉強にもなるのでこのような機会をいただけて感謝です。',
      1, '2024-01-26 10:00:00', '2024-01-26 10:00:00', '2024-01-26'),
    ('今日は担当していたタスクがひと段落して、マージさせてもらうことができました。挙動として修正したい部分が残っているので、開発の状況で進めていければと思います。今日のタスクも一通り実装をすることができて、少し安心しました。データベースの設計は開発において非常に重要だなと感じることが多くなってきました。あと少ししかチーム開発の期間がないので大切に取り組んでいきたいと思います',
      2, '2024-01-26 12:30:00', '2024-01-26 12:30:00', '2024-01-26'),
    ('開発は大変ですが、考えて試して出来がっていくのを見ると楽しさもありつい時間を忘れてやってしまいます。あと少しですが頑張ります。',
      3, '2024-01-26 15:45:00', '2024-01-26 15:45:00', '2024-01-26'),
    -- 27日
    ('作業をしていたら寝ていたので昨日の分の日報を書いておきます。昨日は、最低限の実装はなんとか終わったので良かったですが、最後にうまくいかない部分も出てきたので少し焦りました、今日の発表までに調整できるところはできるだけやっておきたいです。',
      1, '2024-01-27 11:00:00', '2024-01-27 11:00:00', '2024-01-27'),
    ('アプリの主な機能の実装が完了しました。行けたら実装したいねの部分に着手されていて、まさかのサプライズに感動しました！今回チーム開発を進める上で、必須なツールの利用や優位性を強く学ばせていただけることが多かったです。そして学ばせていただけることばかりで本当にいい経験をさせてもらいました。明日の発表まであと少しですが、この経験を大切にしていきたいです。',
      2, '2024-01-27 14:30:00', '2024-01-27 14:30:00', '2024-01-27'),
    ('アプリは目標通りほぼ出来あがりました。私のGitHubがうまく動かない中チームの皆さんに助けていただき感謝でいっぱいです。プレゼンやデモの練習に力を入れたいと思います。',
      3, '2024-01-27 17:15:00', '2024-01-27 17:15:00', '2024-01-27');

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
