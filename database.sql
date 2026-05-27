-- ============================================================
--  База данных для сайта приюта животных «Лапки»
--  Курсовой проект по дисциплине «Серверная веб-разработка»
--  Импортируйте файл в phpMyAdmin или: mysql -u root < database.sql
-- ============================================================

SET NAMES utf8mb4;

CREATE DATABASE IF NOT EXISTS `lapki`
    DEFAULT CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;

USE `lapki`;

-- =====================  Пользователи  =======================
-- Роль admin даёт доступ к панели управления.
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
    `id`            int(11)      NOT NULL AUTO_INCREMENT,
    `nickname`      varchar(128) NOT NULL,
    `email`         varchar(255) NOT NULL,
    `password_hash` varchar(255) NOT NULL,
    `role`          enum('admin','user') NOT NULL DEFAULT 'user',
    `created_at`    datetime     NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    UNIQUE KEY `nickname` (`nickname`),
    UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Пароль администратора: admin123  (хранится в виде password_hash)
INSERT INTO `users` (`nickname`, `email`, `password_hash`, `role`) VALUES
('admin', 'admin@lapki.ru', '$2y$10$ty9iw4hnztYpcXDsk6mOWOwx1YYeZfD3i2kkYTLer2VQYMtW6N39q', 'admin'),
('volunteer', 'vol@lapki.ru', '$2y$10$ty9iw4hnztYpcXDsk6mOWOwx1YYeZfD3i2kkYTLer2VQYMtW6N39q', 'user');

-- =====================  Питомцы  ============================
-- Это и каталог на витрине, и таблица для CRUD в админке
-- (по аналогии с «записной книжкой»: множество полей-атрибутов).
DROP TABLE IF EXISTS `pets`;
CREATE TABLE `pets` (
    `id`          int(11)      NOT NULL AUTO_INCREMENT,
    `name`        varchar(128) NOT NULL,                       -- кличка
    `species`     enum('cat','dog','other') NOT NULL,          -- вид
    `breed`       varchar(128) NOT NULL DEFAULT '',            -- порода
    `gender`      enum('male','female') NOT NULL,              -- пол
    `age_months`  int(11)      NOT NULL DEFAULT 0,             -- возраст в месяцах
    `weight_kg`   decimal(5,2) NOT NULL DEFAULT 0.00,          -- вес, кг
    `color`       varchar(64)  NOT NULL DEFAULT '',            -- окрас
    `activity`    enum('low','normal','high') NOT NULL DEFAULT 'normal', -- активность
    `description` text         NOT NULL,                       -- описание
    `photo_url`   varchar(255) NOT NULL DEFAULT '',            -- ссылка на фото (эмодзи/url)
    `status`      enum('available','reserved','adopted') NOT NULL DEFAULT 'available',
    `created_at`  datetime     NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `pets`
(`name`,`species`,`breed`,`gender`,`age_months`,`weight_kg`,`color`,`activity`,`description`,`photo_url`,`status`) VALUES
('Барсик','cat','Беспородный','male',18,4.20,'Рыжий','normal','Ласковый рыжий кот, обожает спать на коленях и тёплые батареи. Приучен к лотку.','/uploads/barsik.png','available'),
('Муся','cat','Британская','female',30,3.80,'Серый','low','Спокойная домоседка, идеальна для тихой семьи. Любит наблюдать за птицами из окна.','/uploads/musya.png','available'),
('Рекс','dog','Овчарка','male',24,28.50,'Чепрачный','high','Энергичный и верный пёс, прошёл базовую дрессировку. Нужен активный хозяин и простор.','/uploads/reks.png','available'),
('Белла','dog','Лабрадор','female',12,18.00,'Палевый','high','Дружелюбный щенок-подросток, обожает детей и игры с мячом. Очень умная.','/uploads/bella.png','reserved'),
('Тиша','cat','Беспородный','male',60,5.10,'Чёрный','low','Солидный взрослый кот с характером, любит уют и размеренную жизнь. Подойдёт спокойному дому.','/uploads/tisha.png','available'),
('Локи','dog','Хаски','male',36,22.30,'Чёрно-белый','high','Невероятно активный хаски, нужен опытный хозяин и долгие прогулки. Обожает бегать.','/uploads/loki.png','available'),
('Соня','cat','Сиамская','female',8,2.60,'Колор-пойнт','normal','Игривая молодая кошечка, очень общительная и любопытная. Быстро привыкает к людям.','/uploads/sonya.png','available'),
('Граф','dog','Такса','male',48,7.40,'Рыжий','normal','Умный и преданный таксик, отлично ладит с другими животными. Любит длинные прогулки.','/uploads/graf.png','adopted'),
('Дымка','cat','Беспородная','female',15,3.30,'Дымчатый','normal','Нежная и тихая кошка, очень привязывается к хозяину. Мечтает о любящем доме.','/uploads/dymka.png','available'),
('Бади','dog','Бигль','male',20,12.10,'Трёхцветный','high','Весёлый и любознательный бигль, обожает нюхать всё вокруг. Нужны активные прогулки.','/uploads/badi.png','available'),
('Тесс','other','Карликовый хотот','female',48,1.40,'Белый с серым','normal','Очаровательная крольчиха карликовой породы хотот. Спокойная, чистоплотная и контактная. Будет рада уютному дому и свежей зелени.','/uploads/tess.png','available'),
('Пушок','cat','Мейн-кун','male',40,7.80,'Мраморный','normal','Огромный добродушный мейн-кун, ласковый гигант. Прекрасно ладит со всеми.','/uploads/pushok.png','available');

-- =====================  Статьи (блог)  =====================
-- Связь author_id -> users.id
DROP TABLE IF EXISTS `articles`;
CREATE TABLE `articles` (
    `id`         int(11)      NOT NULL AUTO_INCREMENT,
    `author_id`  int(11)      NOT NULL,
    `name`       varchar(255) NOT NULL,
    `text`       text         NOT NULL,
    `created_at` datetime     NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `articles` (`author_id`,`name`,`text`) VALUES
(1,'Как подготовить дом к появлению питомца','Перед тем как забрать животное из приюта, важно подготовить пространство. Уберите провода и мелкие предметы, которые питомец может проглотить. Организуйте укромное место с лежанкой, мисками для воды и корма. Для кошки понадобится лоток и когтеточка, для собаки — место для сна и игрушки. Запаситесь кормом, который животное получало в приюте, чтобы не менять рацион резко. Терпение в первые недели — залог успешной адаптации нового члена семьи.'),
(1,'Чем кормить кошку: основы здорового рациона','Правильное питание — основа здоровья кошки. Рацион должен содержать достаточно белка, ведь кошки — облигатные хищники. Выбирайте корма премиум-класса или сбалансированное натуральное питание после консультации с ветеринаром. Следите за нормой: переедание ведёт к ожирению, а недокорм — к истощению. Воспользуйтесь нашим калькулятором нормы корма, чтобы рассчитать суточную порцию исходя из веса, возраста и активности вашего питомца. Всегда обеспечивайте доступ к свежей воде.'),
(2,'Первая прогулка с собакой из приюта','Собака из приюта может испытывать стресс на первой прогулке. Начните с тихих мест без большого скопления людей и животных. Используйте надёжную шлейку и поводок — испуганное животное может попытаться убежать. Двигайтесь спокойно, давайте питомцу время обнюхать территорию и освоиться. Поощряйте лакомством за спокойное поведение. Постепенно увеличивайте длительность и сложность маршрутов. Доверие выстраивается не за один день, но каждая прогулка приближает вас друг к другу.'),
(1,'Адаптация животного в новом доме','Первые дни на новом месте — самые важные. Дайте питомцу время освоиться, не торопите события и не приглашайте сразу много гостей. Покажите, где находятся еда, вода и место для туалета. Сохраняйте спокойную атмосферу. Кошке дайте возможность спрятаться и выйти, когда она будет готова. Собаке установите режим прогулок и кормления — предсказуемость снижает тревогу. Любовь, терпение и стабильный распорядок помогут животному почувствовать себя дома.');

-- =====================  Заявки/обращения  ==================
-- Сюда сохраняются данные из формы обратной связи (лаба 1).
DROP TABLE IF EXISTS `feedback`;
CREATE TABLE `feedback` (
    `id`          int(11)      NOT NULL AUTO_INCREMENT,
    `name`        varchar(128) NOT NULL,
    `email`       varchar(255) NOT NULL,
    `type`        enum('adopt','volunteer','question','gratitude') NOT NULL,
    `message`     text         NOT NULL,
    `reply_sms`   tinyint(1)   NOT NULL DEFAULT 0,
    `reply_email` tinyint(1)   NOT NULL DEFAULT 0,
    `created_at`  datetime     NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `feedback` (`name`,`email`,`type`,`message`,`reply_sms`,`reply_email`) VALUES
('Анна Петрова','anna@example.com','adopt','Здравствуйте! Хотела бы забрать кошечку Мусю. Когда можно приехать познакомиться?',0,1),
('Иван Сидоров','ivan@example.com','volunteer','Готов помогать приюту по выходным — выгул собак, уборка. Как стать волонтёром?',1,1);
