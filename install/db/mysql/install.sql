CREATE TABLE IF NOT EXISTS `ibs_shop_notebook_brands` (
    `ID`  INT(11) NOT NULL AUTO_INCREMENT,
    `NAME` VARCHAR(255) NOT NULL,
    `CODE` TEXT,
    PRIMARY KEY (`ID`)
);

CREATE TABLE IF NOT EXISTS `ibs_shop_notebook_models` (
    `ID`  INT(11) NOT NULL AUTO_INCREMENT,
    `ID_BRAND`  INT(11) NOT NULL,
    `NAME` VARCHAR(255) NOT NULL,
    `CODE` TEXT,
    PRIMARY KEY (`ID`)
);

CREATE TABLE IF NOT EXISTS `ibs_shop_notebook_notebooks` (
    `ID`  INT(11) NOT NULL AUTO_INCREMENT,
    `ID_MODEL`  INT(11) NOT NULL,
    `NAME` VARCHAR(255) NOT NULL,
    `CODE` TEXT,
    `YEAR` INT(4) NOT NULL,
    `PRICE` float(11) NOT NULL,
    PRIMARY KEY (`ID`)
);

CREATE TABLE IF NOT EXISTS `ibs_shop_notebook_props` (
    `ID`  INT(11) NOT NULL AUTO_INCREMENT,
    `NAME` VARCHAR(255) NOT NULL,
    `CODE` TEXT,
    PRIMARY KEY (`ID`)
);

CREATE TABLE IF NOT EXISTS `ibs_shop_notebook_props_values` (
    `ID`  INT(11) NOT NULL AUTO_INCREMENT,
    `ID_PROP`  INT(11) NOT NULL,
    `ID_NOTEBOOK`  INT(11) NOT NULL,
    `VALUE` VARCHAR(255) NOT NULL,
    `CODE` TEXT,
    PRIMARY KEY (`ID`)
);


# DEMO DATA
INSERT INTO `ibs_shop_notebook_brands` VALUES
      (NULL,'Samsung', 'samsung'),
      (NULL,'MSI', 'msi'),
      (NULL,'Apple', 'apple');

INSERT INTO ibs_shop_notebook_models VALUES
    (NULL, (SELECT ibs_shop_notebook_brands.ID from ibs_shop_notebook_brands where NAME='Samsung'), 'D100', 'd100'),
    (NULL, (SELECT ibs_shop_notebook_brands.ID from ibs_shop_notebook_brands where NAME='Samsung'), 'D200', 'd200'),
    (NULL, (SELECT ibs_shop_notebook_brands.ID from ibs_shop_notebook_brands where NAME='Samsung'), 'D300', 'd300'),
    (NULL, (SELECT ibs_shop_notebook_brands.ID from ibs_shop_notebook_brands where NAME='MSI'), 'GX40', 'gx40'),
    (NULL, (SELECT ibs_shop_notebook_brands.ID from ibs_shop_notebook_brands where NAME='MSI'), 'GX44', 'gx44'),
    (NULL, (SELECT ibs_shop_notebook_brands.ID from ibs_shop_notebook_brands where NAME='MSI'), 'GX46', 'gx46'),
    (NULL, (SELECT ibs_shop_notebook_brands.ID from ibs_shop_notebook_brands where NAME='Apple'), 'MacBook air', 'macbook_air'),
    (NULL, (SELECT ibs_shop_notebook_brands.ID from ibs_shop_notebook_brands where NAME='Apple'), 'MacBook pro 13', 'macbook_pro_13'),
    (NULL, (SELECT ibs_shop_notebook_brands.ID from ibs_shop_notebook_brands where NAME='Apple'), 'MacBook pro 15', 'macbook_pro_15');

INSERT INTO ibs_shop_notebook_notebooks VALUES
    (NULL, (SELECT ibs_shop_notebook_models.ID from ibs_shop_notebook_models where NAME='D100'), 'Samsung D100', 'samsung_d100', 2020, 45000),
    (NULL, (SELECT ibs_shop_notebook_models.ID from ibs_shop_notebook_models where NAME='D200'), 'Samsung D200', 'samsung_d200', 2021, 49999.90),
    (NULL, (SELECT ibs_shop_notebook_models.ID from ibs_shop_notebook_models where NAME='D300'), 'Samsung D300', 'samsung_d300', 2022, 56599.50);

INSERT INTO ibs_shop_notebook_props VALUES
    (NULL,'Процессор', 'processor'),
    (NULL,'Оперативная память', 'ram'),
    (NULL,'Жесткий диск', 'hard');

INSERT INTO ibs_shop_notebook_props_values VALUES
    (NULL,(SELECT ibs_shop_notebook_props.ID from ibs_shop_notebook_props where CODE='processor'), (SELECT ibs_shop_notebook_notebooks.ID from ibs_shop_notebook_notebooks where CODE='samsung_d100'),'Intel Core I5', 'intel_core_i5'),
    (NULL,(SELECT ibs_shop_notebook_props.ID from ibs_shop_notebook_props where CODE='processor'), (SELECT ibs_shop_notebook_notebooks.ID from ibs_shop_notebook_notebooks where CODE='samsung_d200'),'Intel Core I5', 'intel_core_i5'),
    (NULL,(SELECT ibs_shop_notebook_props.ID from ibs_shop_notebook_props where CODE='processor'), (SELECT ibs_shop_notebook_notebooks.ID from ibs_shop_notebook_notebooks where CODE='samsung_d300'),'Intel Core I7', 'intel_core_i7'),
    (NULL,(SELECT ibs_shop_notebook_props.ID from ibs_shop_notebook_props where CODE='ram'), (SELECT ibs_shop_notebook_notebooks.ID from ibs_shop_notebook_notebooks where CODE='samsung_d100'),'8 Гб', '8_gb'),
    (NULL,(SELECT ibs_shop_notebook_props.ID from ibs_shop_notebook_props where CODE='ram'), (SELECT ibs_shop_notebook_notebooks.ID from ibs_shop_notebook_notebooks where CODE='samsung_d200'),'8 Гб', '8_gb'),
    (NULL,(SELECT ibs_shop_notebook_props.ID from ibs_shop_notebook_props where CODE='ram'), (SELECT ibs_shop_notebook_notebooks.ID from ibs_shop_notebook_notebooks where CODE='samsung_d300'),'16 Гб', '16_gb'),
    (NULL,(SELECT ibs_shop_notebook_props.ID from ibs_shop_notebook_props where CODE='hard'), (SELECT ibs_shop_notebook_notebooks.ID from ibs_shop_notebook_notebooks where CODE='samsung_d100'),'250 Гб', '250_gb'),
    (NULL,(SELECT ibs_shop_notebook_props.ID from ibs_shop_notebook_props where CODE='hard'), (SELECT ibs_shop_notebook_notebooks.ID from ibs_shop_notebook_notebooks where CODE='samsung_d200'),'250 Гб', '250_gb'),
    (NULL,(SELECT ibs_shop_notebook_props.ID from ibs_shop_notebook_props where CODE='hard'), (SELECT ibs_shop_notebook_notebooks.ID from ibs_shop_notebook_notebooks where CODE='samsung_d300'),'500 Гб', '500_gb');