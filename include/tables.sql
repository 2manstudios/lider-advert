
# данные статистики



# данные формы подачи объявления

# Действующий бизнес
CREATE TABLE IF NOT EXISTS `business` (
    `id` SMALLINT(2) UNSIGNED NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(5) COLLATE utf8_general_ci NOT NULL,

    PRIMARY KEY `id` (`id`)
);

# Доп. платежи
CREATE TABLE IF NOT EXISTS `fees` (
    `id` SMALLINT(2) UNSIGNED NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(25) COLLATE utf8_general_ci NOT NULL,

    PRIMARY KEY `id` (`id`)
);

# Тип предложения
CREATE TABLE IF NOT EXISTS `typeOffer` (
    `id` SMALLINT(2) UNSIGNED NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(50) COLLATE utf8_general_ci NOT NULL,

    PRIMARY KEY `id` (`id`)
);

# Обмен
CREATE TABLE IF NOT EXISTS `exchange` (
    `id` SMALLINT(2) UNSIGNED NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(50) COLLATE utf8_general_ci NOT NULL,

    PRIMARY KEY `id` (`id`)
);

# Тип цены
CREATE TABLE IF NOT EXISTS `costType` (
    `id` SMALLINT(2) UNSIGNED NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(15) COLLATE utf8_general_ci NOT NULL,

    PRIMARY KEY `id` (`id`)
);

CREATE TABLE IF NOT EXISTS `currency` (
    `id` SMALLINT(2) UNSIGNED NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(15) COLLATE utf8_general_ci NOT NULL,

    PRIMARY KEY `id` (`id`)
);

# Назначение
CREATE TABLE IF NOT EXISTS `appointment` (
    `id` SMALLINT(2) UNSIGNED NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(50) COLLATE utf8_general_ci NOT NULL,

    PRIMARY KEY `id` (`id`)
);

# сфера деятельности
CREATE TABLE IF NOT EXISTS `sphere` (
    `id` SMALLINT(2) UNSIGNED NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(50) COLLATE utf8_general_ci NOT NULL,

    PRIMARY KEY `id` (`id`)
);

CREATE TABLE IF NOT EXISTS `material` (
    `id` SMALLINT(2) UNSIGNED NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(50) COLLATE utf8_general_ci NOT NULL,

    PRIMARY KEY `id` (`id`)
);

CREATE TABLE IF NOT EXISTS `newbuilding` (
    `id` SMALLINT(1) UNSIGNED NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(25) COLLATE utf8_general_ci NOT NULL,

    PRIMARY KEY `id` (`id`)
);

# Тип объекта
CREATE TABLE IF NOT EXISTS `object` (
    `id` SMALLINT(2) UNSIGNED NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(50) COLLATE utf8_general_ci NOT NULL,

    PRIMARY KEY `id` (`id`)
);

# Тип операции
CREATE TABLE IF NOT EXISTS `property` (
    `id` SMALLINT(1) UNSIGNED NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(25) COLLATE utf8_general_ci NOT NULL,
    
    PRIMARY KEY `id` (`id`)
);

CREATE TABLE IF NOT EXISTS `realtyDetail` (
    `id` SMALLINT(2) UNSIGNED NOT NULL AUTO_INCREMENT,
    `realty_id` SMALLINT(1) UNSIGNED NOT NULL DEFAULT 0,
    `name` VARCHAR(50) COLLATE utf8_general_ci NOT NULL,

    KEY `realty_id` (`realty_id`),
    PRIMARY KEY `id` (`id`)
);

CREATE TABLE IF NOT EXISTS `realty` (
    `id` SMALLINT(1) UNSIGNED NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(25) COLLATE utf8_general_ci NOT NULL,

    PRIMARY KEY `id` (`id`)
);

CREATE TABLE IF NOT EXISTS `squareLandUnit` (
    `id` SMALLINT(1) UNSIGNED NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(10) COLLATE utf8_general_ci NOT NULL,

    PRIMARY KEY `id` (`id`)
);

# список Значений параметров сайтов
CREATE TABLE IF NOT EXISTS `siteParamsValue` (
    `id` SMALLINT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
    `tableValue_id` SMALLINT(2) UNSIGNED NOT NULL DEFAULT 0,
    `siteParam_id` SMALLINT(2) UNSIGNED NOT NULL DEFAULT 0,
    `parent_id` SMALLINT(11) UNSIGNED NOT NULL DEFAULT 0,
    `value` VARCHAR(50) COLLATE utf8_general_ci NOT NULL,
    `name` VARCHAR(50) COLLATE utf8_general_ci NOT NULL,

    KEY `tableValue_id` (`tableValue_id`),
    KEY `siteParam_id` (`siteParam_id`),
    KEY `combo` (`tableValue_id`, `siteParam_id`),
    PRIMARY KEY `id` (`id`)
);

# список параметров сайтов
CREATE TABLE IF NOT EXISTS `siteParams` (
    `id` SMALLINT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
    `our_id` SMALLINT(3) UNSIGNED NOT NULL DEFAULT 0,
    `site_id` SMALLINT(2) UNSIGNED NOT NULL DEFAULT 0,
    `var` VARCHAR(50) COLLATE utf8_general_ci NOT NULL,

    KEY `our_id` (`our_id`),
    KEY `site_id` (`site_id`),
    KEY `combo` (`our_id`, `site_id`),
    PRIMARY KEY `id` (`id`)
);

# список наших параметров
CREATE TABLE IF NOT EXISTS `ourParams` (
    `id` SMALLINT(3) UNSIGNED NOT NULL AUTO_INCREMENT,
    `var` VARCHAR(50) COLLATE utf8_general_ci NOT NULL,
    `type1` SMALLINT(1) UNSIGNED NOT NULL DEFAULT 0, # 0 - normal, 1 - from other table
    `type2` SMALLINT(1) UNSIGNED NOT NULL DEFAULT 0, # 0 - radio, 1 - select, 2 - input, 3 - textarea
    `label` VARCHAR(50) COLLATE utf8_general_ci NOT NULL,
    `min_value` SMALLINT(2) UNSIGNED NOT NULL DEFAULT 0,
    `max_value` SMALLINT(2) UNSIGNED NOT NULL DEFAULT 0,

    PRIMARY KEY `id` (`id`)
);

# данные клиентов

CREATE TABLE IF NOT EXISTS `advertStatus` (
    `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
    `advert_id` INT(11) UNSIGNED NOT NULL DEFAULT 0,
    `onSite_id` VARCHAR(50) COLLATE utf8_general_ci NOT NULL,
    `status` SMALLINT(1) UNSIGNED NOT NULL DEFAULT 0, # состояние объявления
    `type` SMALLINT(1) UNSIGNED NOT NULL DEFAULT 0,     # платное / бесплатное
    `view` SMALLINT(6) UNSIGNED NOT NULL DEFAULT 0,     # просмотров
    `dt_update` TIMESTAMP NOT NULL,
    `dt_stop` TIMESTAMP NOT NULL,
    `dt_extension` TIMESTAMP NOT NULL,

    KEY `advert_id` (`advert_id`),    
    PRIMARY KEY `id` (`id`)
);

CREATE TABLE IF NOT EXISTS `advert` (
    `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
    `user_id` INT(11) UNSIGNED NOT NULL DEFAULT 0,  
    `status` SMALLINT(1) UNSIGNED NOT NULL DEFAULT 0, # состояние объявления
    `region_id` SMALLINT(1) UNSIGNED NOT NULL DEFAULT 0,
    `district_id` SMALLINT(1) UNSIGNED NOT NULL DEFAULT 0,    
    `town_id` SMALLINT(1) UNSIGNED NOT NULL DEFAULT 0,
    `microDistrict_id` SMALLINT(1) UNSIGNED NOT NULL DEFAULT 0,
    `street_id` SMALLINT(1) UNSIGNED NOT NULL DEFAULT 0,
    `realty_id` SMALLINT(1) UNSIGNED NOT NULL DEFAULT 0, # Категория
    `realtyDetail_id` SMALLINT(1) UNSIGNED NOT NULL DEFAULT 0, # Тип недвижимости
    `property_id` SMALLINT(1) UNSIGNED NOT NULL DEFAULT 0, # Тип операции
    `object_id` SMALLINT(1) UNSIGNED NOT NULL DEFAULT 0, # Тип объекта
    `newbuilding_id` SMALLINT(1) UNSIGNED NOT NULL DEFAULT 0, # Новострой
    `material_id` SMALLINT(1) UNSIGNED NOT NULL DEFAULT 0, # материал
    `sphere_id` SMALLINT(1) UNSIGNED NOT NULL DEFAULT 0, # сфера деятельности
    `appointment_id` SMALLINT(1) UNSIGNED NOT NULL DEFAULT 0, # Назначение
    `typeOffer_id` SMALLINT(1) UNSIGNED NOT NULL DEFAULT 0, # Тип предложения
    `exchange_id` SMALLINT(1) UNSIGNED NOT NULL DEFAULT 0, # Обмен
    `squareLandUnit_id` SMALLINT(1) UNSIGNED NOT NULL DEFAULT 0, # ед. измерения
    `currency_id` SMALLINT(1) UNSIGNED NOT NULL DEFAULT 0, # валюта
    `costType_id` SMALLINT(1) UNSIGNED NOT NULL DEFAULT 0, # Тип цены
    `fees_id` SMALLINT(1) UNSIGNED NOT NULL DEFAULT 0, # Доп. платежи
    `business_id` SMALLINT(1) UNSIGNED NOT NULL DEFAULT 0, # Действующий бизнес
    `rooms` SMALLINT(6) UNSIGNED NOT NULL DEFAULT 0,
    `squareFull` FLOAT(11, 2) UNSIGNED NOT NULL DEFAULT 0,
    `squareLive` FLOAT(11, 2) UNSIGNED NOT NULL DEFAULT 0,
    `squareKitchen` FLOAT(11, 2) UNSIGNED NOT NULL DEFAULT 0,
    `costSell` FLOAT(11, 2) UNSIGNED NOT NULL DEFAULT 0,
    `costMonth` FLOAT(11, 2) UNSIGNED NOT NULL DEFAULT 0,
    `costDay` FLOAT(11, 2) UNSIGNED NOT NULL DEFAULT 0,
    `costWeek` FLOAT(11, 2) UNSIGNED NOT NULL DEFAULT 0,
    `costHour` FLOAT(11, 2) UNSIGNED NOT NULL DEFAULT 0,
    `bedroomsCount` SMALLINT(6) UNSIGNED NOT NULL DEFAULT 0, # Количество спален
    `roomsCount` SMALLINT(6) UNSIGNED NOT NULL DEFAULT 0, # Количество помещений
    `sleeps` SMALLINT(6) UNSIGNED NOT NULL DEFAULT 0, # Спальных мест
    `seatsHall` SMALLINT(6) UNSIGNED NOT NULL DEFAULT 0, # Количество мест
    `squareLand` FLOAT(11, 2) UNSIGNED NOT NULL DEFAULT 0,    
    `squareUseful` FLOAT(11, 2) UNSIGNED NOT NULL DEFAULT 0, # полезная    
    `parkingCount` SMALLINT(6) UNSIGNED NOT NULL DEFAULT 0, # Машиномест
    `floor` SMALLINT(6) UNSIGNED NOT NULL DEFAULT 0, # Этаж
    `numberOfFloors` SMALLINT(6) UNSIGNED NOT NULL DEFAULT 0, # Этажность
    `numberOfFloorsResidential` SMALLINT(6) UNSIGNED NOT NULL DEFAULT 0, # Жилых этажей
    `house_number` VARCHAR(10) COLLATE utf8_general_ci NOT NULL,    
    `description` TEXT COLLATE utf8_general_ci NOT NULL,    
    `dt_add` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `dt_update` TIMESTAMP NOT NULL,
    

    KEY `site_id` (`site_id`),
    KEY `user_id` (`user_id`),
    KEY `combo` (`user_id`, `site_id`),
    PRIMARY KEY `id` (`id`)
);

CREATE TABLE IF NOT EXISTS `advertImages` (
    `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
    `advert_id` INT(11) UNSIGNED NOT NULL DEFAULT 0,
    `image` VARCHAR(50) COLLATE utf8_general_ci NOT NULL,

    KEY `advert_id` (`advert_id`),    
    PRIMARY KEY `id` (`id`)
);

CREATE TABLE IF NOT EXISTS `user` (
    `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(50) COLLATE utf8_general_ci NOT NULL,
    `email`  VARCHAR(50) COLLATE utf8_general_ci NOT NULL,    
    `phone` VARCHAR(20) COLLATE utf8_general_ci NOT NULL,
    `address` VARCHAR(100) COLLATE utf8_general_ci NOT NULL,
    `pass` VARCHAR(50) COLLATE utf8_general_ci NOT NULL,
    `pass_hex` VARCHAR(50) COLLATE utf8_general_ci NOT NULL,    
    `birth_day` DATE NOT NULL,    
    `sex` SMALLINT(1) UNSIGNED NOT NULL DEFAULT 0,
    `newsletter` SMALLINT(1) UNSIGNED NOT NULL DEFAULT 1,
    `report` SMALLINT(1) UNSIGNED NOT NULL DEFAULT 1,
    `republic` SMALLINT(1) UNSIGNED NOT NULL DEFAULT 0,
    `status` SMALLINT(1) UNSIGNED NOT NULL DEFAULT 1,
    `dt_add` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `dt_update` TIMESTAMP NOT NULL,

    PRIMARY KEY `id` (`id`)
);


# данные по сайтам

CREATE TABLE IF NOT EXISTS `site` (
    `id` SMALLINT(2) UNSIGNED NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(50) COLLATE utf8_general_ci NOT NULL,
    `logo` VARCHAR(20) COLLATE utf8_general_ci NOT NULL,
    `status` SMALLINT(1) UNSIGNED NOT NULL DEFAULT 0,
    `type` SMALLINT(1) UNSIGNED NOT NULL DEFAULT 0,
    `urlViewAdvert` VARCHAR(50) COLLATE utf8_general_ci NOT NULL,
    `msg` VARCHAR(100) COLLATE utf8_general_ci NOT NULL,
    `dt_add` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `dt_update` TIMESTAMP NOT NULL,

    PRIMARY KEY `id` (`id`)
);

CREATE TABLE IF NOT EXISTS `site_tariff` (
    `id` SMALLINT(3) UNSIGNED NOT NULL AUTO_INCREMENT,
    `site_id` SMALLINT(2) UNSIGNED NOT NULL DEFAULT 0,
    `name` VARCHAR(50) COLLATE utf8_general_ci NOT NULL,
    `price` FLOAT(5, 2) UNSIGNED NOT NULL DEFAULT 0,
    `dt_add` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `dt_update` TIMESTAMP NOT NULL

    KEY `site_id` (`site_id`),
    PRIMARY KEY `id` (`id`)
);


#   адресные данные

CREATE TABLE IF NOT EXISTS `country` (
    `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,    
    `name` VARCHAR(50) COLLATE utf8_general_ci NOT NULL,

    PRIMARY KEY `id` (`id`) 
);

CREATE TABLE IF NOT EXISTS `region` (
    `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
    `country_id` INT(11) UNSIGNED NOT NULL DEFAULT 0,
    `name` VARCHAR(50) COLLATE utf8_general_ci NOT NULL,

    KEY `country_id` (`country_id`),
    PRIMARY KEY `id` (`id`) 
);

CREATE TABLE IF NOT EXISTS `district` (
    `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
    `region_id` INT(11) UNSIGNED NOT NULL DEFAULT 0,
    `name` VARCHAR(50) COLLATE utf8_general_ci NOT NULL,
    `main` SMALLINT(1) UNSIGNED NOT NULL DEFAULT 0,

    KEY `region_id` (`region_id`),
    PRIMARY KEY `id` (`id`) 
);

CREATE TABLE IF NOT EXISTS `microDistrict` (
    `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
    `town_id` INT(11) UNSIGNED NOT NULL DEFAULT 0,
    `name` VARCHAR(50) COLLATE utf8_general_ci NOT NULL,

    KEY `town_id` (`town_id`),
    PRIMARY KEY `id` (`id`) 
);

CREATE TABLE IF NOT EXISTS `town` (
    `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
    `district_id` INT(11) UNSIGNED NOT NULL DEFAULT 0,    
    `name` VARCHAR(50) COLLATE utf8_general_ci NOT NULL,

    KEY `district_id` (`district_id`),
    PRIMARY KEY `id` (`id`) 
);

CREATE TABLE IF NOT EXISTS `street` (
    `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
    `region_id` INT(11) UNSIGNED NOT NULL DEFAULT 0,
    `name` VARCHAR(50) COLLATE utf8_general_ci NOT NULL,
    
    KEY `region_id` (`region_id`),
    PRIMARY KEY `id` (`id`)  
);