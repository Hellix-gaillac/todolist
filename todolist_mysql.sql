CREATE DATABASE IF NOT EXISTS `TODOLIST` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `TODOLIST`;

CREATE TABLE `USAGER` (
  `id_usager` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nom` VARCHAR(42),
  `prenom` VARCHAR(42),
  PRIMARY KEY (`id_usager`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



CREATE TABLE `LISTE` (
  `id_liste` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_usager` INT UNSIGNED,
  `titre` VARCHAR(42),
  PRIMARY KEY (`id_liste`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



CREATE TABLE `TODO` (
  `id_todo` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_liste` INT UNSIGNED,
  `titre` VARCHAR(42),
  `detail` MEDIUMTEXT,
  `date_debut` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_todo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



INSERT INTO `usager` (`id_usager`, `nom`, `prenom`) VALUES
(DEFAULT, 'Loup', 'Alice'),
(DEFAULT, 'Marty', 'Michel'),
(DEFAULT, 'Diaz', 'José'),
(DEFAULT, 'Lopez', 'Ernest'),
(DEFAULT, 'Tirole', 'Jean');

INSERT INTO `liste` (`id_liste`, `id_usager`, `titre`) VALUES
(DEFAULT, 1, 'Maison'),
(DEFAULT, 1, 'Crèche'),
(DEFAULT, 1, 'Vacance'),
(DEFAULT, 1, 'Boulot'),
(DEFAULT, 2, 'Bistrot'),
(DEFAULT, 5, 'Vacance'),
(DEFAULT, 2, 'Boulot'),
(DEFAULT, 3, 'Maison'),
(DEFAULT, 3, 'Travail'),
(DEFAULT, 4, 'Maison'),
(DEFAULT, 4, 'Travail'),
(DEFAULT, 5, 'Vacance');


INSERT INTO `todo` (`id_todo`, `id_liste`, `titre`, `detail`, `date_debut`) VALUES
(DEFAULT, 1,'Cuius', 'Cuius acerbitati uxor grave accesserat incentivum, germanitate Augusti turgida supra modum,',CURRENT_TIMESTAMP),
(DEFAULT, 1,'regni', 'Crèchadfectati regni vel artium nefandarum calumnias insontibus adfligebant.e',CURRENT_TIMESTAMP),
(DEFAULT, 2,'acrius', 'Thalassius vero ea tempestate praefec',CURRENT_TIMESTAMP),
(DEFAULT, 2,'regni', 'Cuius acerbitati uxor grave accesserat incentivum, germanitate Augusti turgida supra modum,',CURRENT_TIMESTAMP),
(DEFAULT, 3,'Cuius', 'Thalassius vero ea tempestate praefec',CURRENT_TIMESTAMP),
(DEFAULT, 3,'acrius', 'adfectati regni vel artium nefandarum calumnias insontibus adfligebant.',CURRENT_TIMESTAMP),
(DEFAULT, 4,'regni', 'Thalassius vero ea tempestate praefec',CURRENT_TIMESTAMP),
(DEFAULT, 1,'Cuius', 'Cuius acerbitati uxor grave accesserat incentivum, germanitate Augusti turgida supra modum,',CURRENT_TIMESTAMP),
(DEFAULT, 2,'acrius', 'Thalassius vero ea tempestate praefec',CURRENT_TIMESTAMP),
(DEFAULT, 2,'regni', 'adfectati regni vel artium nefandarum calumnias insontibus adfligebant.',CURRENT_TIMESTAMP),
(DEFAULT, 2,'Cuius', 'Caesar acrius efferatus, velut contumaciae quoddam vexillum altius erigens,',CURRENT_TIMESTAMP),
(DEFAULT, 3,'acrius', 'Cuius acerbitati uxor grave accesserat incentivum, germanitate Augusti turgida supra modum,',CURRENT_TIMESTAMP),
(DEFAULT, 3,'Cuius', 'Caesar acrius efferatus, velut contumaciae quoddam vexillum altius erigens,',CURRENT_TIMESTAMP),
(DEFAULT, 5,'regni', 'adfectati regni vel artium nefandarum calumnias insontibus adfligebant.',CURRENT_TIMESTAMP),
(DEFAULT, 6,'acrius', 'Cuius acerbitati uxor grave accesserat incentivum, germanitate Augusti turgida supra modum,',CURRENT_TIMESTAMP),
(DEFAULT, 6,'acrius', 'Caesar acrius efferatus, velut contumaciae quoddam vexillum altius erigens,',CURRENT_TIMESTAMP),
(DEFAULT, 6,'Cuius', 'adfectati regni vel artium nefandarum calumnias insontibus adfligebant.',CURRENT_TIMESTAMP),
(DEFAULT, 7,'regni', 'Thalassius vero ea tempestate praefec',CURRENT_TIMESTAMP),
(DEFAULT, 7,'acrius', 'Cuius acerbitati uxor grave accesserat incentivum, germanitate Augusti turgida supra modum,',CURRENT_TIMESTAMP),
(DEFAULT, 8,'Cuius', 'Thalassius vero ea tempestate praefec',CURRENT_TIMESTAMP),
(DEFAULT, 1,'regni', 'Crèchadfectati regni vel artium nefandarum calumnias insontibus adfligebant.e',CURRENT_TIMESTAMP),
(DEFAULT, 2,'acrius', 'Thalassius vero ea tempestate praefec',CURRENT_TIMESTAMP),
(DEFAULT, 2,'regni', 'Cuius acerbitati uxor grave accesserat incentivum, germanitate Augusti turgida supra modum,',CURRENT_TIMESTAMP),
(DEFAULT, 3,'uxor', 'Thalassius vero ea tempestate praefec',CURRENT_TIMESTAMP),
(DEFAULT, 3,'acrius', 'adfectati regni vel artium nefandarum calumnias insontibus adfligebant.',CURRENT_TIMESTAMP),
(DEFAULT, 4,'regni', 'Thalassius vero ea tempestate praefec',CURRENT_TIMESTAMP),
(DEFAULT, 1,'uxor', 'uxor acerbitati uxor grave accesserat incentivum, germanitate Augusti turgida supra modum,',CURRENT_TIMESTAMP),
(DEFAULT, 2,'acrius', 'Thalassius vero ea tempestate praefec',CURRENT_TIMESTAMP),
(DEFAULT, 2,'grave', 'adfectati grave vel artium nefandarum calumnias insontibus adfligebant.',CURRENT_TIMESTAMP),
(DEFAULT, 2,'uxor', 'Caesar acrius efferatus, velut contumaciae quoddam vexillum altius erigens,',CURRENT_TIMESTAMP),
(DEFAULT, 3,'acrius', 'uxor acerbitati uxor grave accesserat incentivum, germanitate Augusti turgida supra modum,',CURRENT_TIMESTAMP),
(DEFAULT, 3,'uxor', 'Caesar acrius efferatus, velut contumaciae quoddam vexillum altius erigens,',CURRENT_TIMESTAMP),
(DEFAULT, 5,'grave', 'adfectati grave vel artium nefandarum calumnias insontibus adfligebant.',CURRENT_TIMESTAMP),
(DEFAULT, 6,'acrius', 'uxor acerbitati uxor grave accesserat incentivum, germanitate Augusti turgida supra modum,',CURRENT_TIMESTAMP),
(DEFAULT, 6,'acrius', 'Caesar acrius efferatus, velut contumaciae quoddam vexillum altius erigens,',CURRENT_TIMESTAMP),
(DEFAULT, 6,'uxor', 'adfectati grave vel artium nefandarum calumnias insontibus adfligebant.',CURRENT_TIMESTAMP),
(DEFAULT, 7,'grave', 'Thalassius vero ea tempestate praefec',CURRENT_TIMESTAMP),
(DEFAULT, 7,'eads', 'uxor acerbitati uxor grave accesserat incentivum, germanitate Augusti turgida supra modum,',CURRENT_TIMESTAMP),
(DEFAULT, 8,'uxor', 'Thalassius vero ea tempestate praefec',CURRENT_TIMESTAMP),
(DEFAULT, 1,'grave', 'Crèchadfectati grave vel artium nefandarum calumnias insontibus adfligebant.e',CURRENT_TIMESTAMP),
(DEFAULT, 12,'eads', 'Thalassius vero ea tempestate praefec',CURRENT_TIMESTAMP),
(DEFAULT, 12,'grave', 'Cuius acerbitati uxor grave accesserat incentivum, germanitate Augusti turgida supra modum,',CURRENT_TIMESTAMP),
(DEFAULT, 9,'Cuius', 'Thalassius vero ea tempestate praefec',CURRENT_TIMESTAMP),
(DEFAULT, 9,'eads', 'adfectati grave vel artium nefandarum calumnias insontibus adfligebant.',CURRENT_TIMESTAMP),
(DEFAULT, 11,'grave', 'Thalassius vero ea tempestate praefec',CURRENT_TIMESTAMP),
(DEFAULT, 11,'Cuius', 'Cuius acerbitati uxor grave accesserat incentivum, germanitate Augusti turgida supra modum,',CURRENT_TIMESTAMP),
(DEFAULT, 12,'eads', 'Thalassius vero ea tempestate praefec',CURRENT_TIMESTAMP),
(DEFAULT, 10,'grave', 'adfectati regni vel artium nefandarum calumnias insontibus adfligebant.',CURRENT_TIMESTAMP),
(DEFAULT, 10,'Cuius', 'Caesar eads efferatus, velut contumaciae quoddam vexillum altius erigens,',CURRENT_TIMESTAMP),
(DEFAULT, 10,'eads', 'Cuius acerbitati uxor grave accesserat incentivum, germanitate Augusti turgida supra modum,',CURRENT_TIMESTAMP),
(DEFAULT, 10,'Cuius', 'Caesar eads efferatus, velut contumaciae quoddam vexillum altius erigens,',CURRENT_TIMESTAMP),
(DEFAULT, 10,'regni', 'adfectati regni vel artium nefandarum calumnias insontibus adfligebant.',CURRENT_TIMESTAMP),
(DEFAULT, 11,'eads', 'Cuius acerbitati uxor grave accesserat incentivum, germanitate Augusti turgida supra modum,',CURRENT_TIMESTAMP),
(DEFAULT, 12,'eads', 'Caesar acrius efferatus, velut contumaciae quoddam vexillum altius erigens,',CURRENT_TIMESTAMP),
(DEFAULT, 9,'Cuius', 'adfectati regni vel artium nefandarum calumnias insontibus adfligebant.',CURRENT_TIMESTAMP),
(DEFAULT, 9,'regni', 'Thalassius vero ea tempestate praefec',CURRENT_TIMESTAMP),
(DEFAULT, 9,'acrius', 'Cuius acerbitati uxor grave accesserat incentivum, germanitate Augusti turgida supra modum,',CURRENT_TIMESTAMP),
(DEFAULT, 10,'Cuius', 'Thalassius vero ea tempestate praefec',CURRENT_TIMESTAMP),
(DEFAULT, 11,'regni', 'adfectati regni vel artium nefandarum calumnias insontibus adfligebant.',CURRENT_TIMESTAMP);

ALTER TABLE `LISTE` ADD FOREIGN KEY (`id_usager`) REFERENCES `USAGER` (`id_usager`);
ALTER TABLE `TODO` ADD FOREIGN KEY (`id_liste`) REFERENCES `LISTE` (`id_liste`);