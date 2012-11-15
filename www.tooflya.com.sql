-- MySQL dump 10.13  Distrib 5.1.63, for debian-linux-gnu (i686)
--
-- Host: localhost    Database: www.tooflya.com
-- ------------------------------------------------------
-- Server version	5.1.63-0ubuntu0.11.10.1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `blog`
--

DROP TABLE IF EXISTS `blog`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `blog` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `text` text NOT NULL,
  `user` int(11) NOT NULL,
  `class` int(11) DEFAULT NULL,
  `article_alias` varchar(155) DEFAULT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `language` int(11) NOT NULL DEFAULT '0',
  `visible` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `user` (`user`),
  KEY `class` (`class`),
  KEY `class_2` (`class`),
  CONSTRAINT `blog_ibfk_3` FOREIGN KEY (`class`) REFERENCES `blog_classes` (`cid`),
  CONSTRAINT `blog_ibfk_1` FOREIGN KEY (`user`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8 COMMENT='Table for store blog entries';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `blog`
--

LOCK TABLES `blog` WRITE;
/*!40000 ALTER TABLE `blog` DISABLE KEYS */;
INSERT INTO `blog` VALUES (6,'Air Penguin Review','<p><img src=\"http://www.tooflya.com/assets/img/blog/jGDj3J0rkG.png\" alt=\"\" class=\"blog-img float-left\" />Plot looks like a scenario of a good blockbuster - because of the global warming ice cracked, and the family of the main character was in different ice floes. And you, like a real superhero, need to reunite with your family, avoiding enemies and obstacles.</p>\r\n<p>Air Penguin - a very popular game for Android, just look at the number of downloads - over 10 million. We have to pass all the levels as a blue penguin. For in-game currency we can buy pink or black penguin or a polar bear, what is very strange - penguins and polar bears live on opposite ends...</p>•\r\n<p class=\"centered\"><img src=\"http://www.tooflya.com/assets/img/blog/jfdpbnk6zV.jpg\" alt=\"\" class=\"blog-img-center\" /></p>\r\n<p>There are a great number of enemies in the game - your first meeting with the grampus you will never forget…</p>\r\n<p class=\"centered\"><img src=\"http://www.tooflya.com/assets/img/blog/KeRZ56y1i6.jpg\" alt=\"\" class=\"blog-img-center\" /></p>\r\n<p>But the game has a pleasant moments in the form of bonus items such as disposal of enemies or subsidiary characters.</p>\r\n<p class=\"centered\"><img src=\"http://www.tooflya.com/assets/img/blog/S2s8qroTLj.jpg\" alt=\"\" class=\"blog-img-center\" /></p>\r\n\r\n\r\n<p>Еру character moves in three ways:\r\n<ul>\r\n<li>Jump from one ice floe to another;</li>\r\n<li>Veers between ice floes on a turtle;</li>\r\n<li>Slides on a huge ice floes on its belly.</li>\r\n</ul>\r\n</p>\r\n<p class=\"centered\">\r\n<img src=\"http://www.tooflya.com/assets/img/blog/rwnPVgyhwu.jpg\" alt=\"\" class=\"blog-img-center\" />\r\n<img src=\"http://www.tooflya.com/assets/img/blog/nfvpQhURak.jpg\" alt=\"\" class=\"blog-img-center\" />\r\n</p>\r\n<p>On Google Play game is free, and recently a number of downloads increases. This only confirms the fact that the game fully deserves its estimate - 4.4.</p>\r\n<p></p>\r\n<b>Developer:</b> Gamevil Inc.<br />\r\n<b>Price:</b> Free<br />\r\n<b>Genre:</b> Arcade and Action<br />',2,1,'review-air-penguin','2012-10-24 09:13:33',0,1);
INSERT INTO `blog` VALUES (9,'Implementation of Screen on Springs','<p>\"- Let\'s make the screen on springs - when the character jumps or falls, screen is a bit late.\r\n  - Hmm. Let\'s do it. \"</p>\r\nThus, the problem - the motion of the character in the vertical screen should keep a certain value; when character stops screen should make some fluctuations up and down.\r\nAfter a little Googling about springs and pendulums and disappointed in the Internet, we came to the following findings and conclusions:\r\n* It is not so easy to find something in the Internet (or I do not know how to search...);\r\n* A description of the actual behavior of a spring or a pendulum rather complex for its use in games;\r\n* For me, as a mathematician, it is easier and more interesting to deduce my own formula, than to spend a couple of hours to watch a heap of useless forums and stuff.\r\nSo, let’s start from the beginning.\r\nOscillations function is easy enough to find. This function will be sin(x).\r\nOscillations must be held vertically (axis y) and depend on the time t.\r\ny(t) = sin(t)\r\nSine values ​​range from -1 to +1. We increase the amplitude of oscillations and obtain the following formula:\r\ny(t) = A * sin(t). (1)\r\nBut the amplitude should attenuate with time, and therefore the variable A must depend on time.\r\nA = f_a(t)\r\nThe simplest method is linear dependence, which can be obtained by two points (x1, y1) и (x2, y2):\r\n(x - x1) / (x2 - x1) = (y - y1) / (y2 - y1). (2)\r\nIt’s, probably, my most popular formula. %)\r\n\r\nNow we should find the two points. It\'s easy! At zero time (t = 0) we must have a maximum amplitude (max_a), but at the last moment (t = max_t), the amplitude is zero. Finally, substituting these terms in (2), we obtain:\r\nmax_a - variable (must be entered by someone);\r\nmax_t - variable (must be entered by someone);\r\n(t - 0) / (max_t - 0) = (A - max_a) / (0 - max_a).\r\nSubstituting all into (1), we have:\r\ny(t) = (1 - t / max_t) * max_a * sin(t), where max_a и max_t - variables.\r\nIt seems everything is fine, but we do not control the number of oscillations. We can fix it if we recall about the periodicity of the sine:\r\nsin(x) = sin(2 * Pi * k * x),\r\nwhere k - the number of oscillations (up and down).\r\nЕсли честно, то на данном этапе я решил, что это результат и пора всё запрограммировать... К сожалению это было не так и некоторые переменные в результате так и не выжили. Но появились новые. Результат:\r\nTo be honest, at this stage I decided that this is the result and it is time to program all this... Unfortunately, this was not the case and some variables have not survived. But appeared new ones:\r\n\r\nmax_a - initial amplitude (maximum vertical shift);\r\ncount_t - number of time units, in which is necessary to calculate the coordinates y;\r\nk - the number of oscillations;\r\nmax_t = 2 * Pi * k - a finite time of oscillations;\r\nstep_t = max_t / count_t - step of variation of the variable t;\r\ny = (1 - t / max_t) * max_a * sin(t), где t[0; step_t... max_t]',3,4,'implementation-of-screen-on-springs','0000-00-00 00:00:00',0,0);
INSERT INTO `blog` VALUES (10,'Bubble Fun - Our New Awesome Game','<p><img src=\"http://www.tooflya.com/assets/img/blog/cdKb6qlz6J.png\" alt=\"\" class=\"blog-img float-left\" />Almost every one of us in the childhood shooted birds from a slingshot, though it is not good ... But childhood is over, and sometimes we so want to get back into it ... Suggest you change slingshots to phones, \"ammunition\" to gum, and let\'s shoot down the birds!<p>\r\n<p>Bubble Fun — childhood simulator. Everything is colorful and fun: birds, sky, chewing gum... The task in the games very easy — you need to shoot down birds with balloons, pouting of gum.</p>•\r\n<p>&nbsp;</p>\r\n<p>You can inflate the balloons of any size, but you should to look after the stock of air, as its quantity is limited. And to get to the birds at each level will be harder and harder, because they will move more chaotically.\r\nAlso in the game you\'ll find a variety of bonuses and features, but we will not talk about them now — we will share that information closer to the release date.</p>\r\n<p><img src=\"http://www.tooflya.com/assets/img/Bubble-Fun-Big-Banner.jpg\" alt=\"\" class=\"blog-img-center\" style=\"width: 700px;\" /></p>\r\n<p><b>Coming soon!</b></p>',2,1,'bubble-fun-review','2012-10-24 05:24:22',0,1);
INSERT INTO `blog` VALUES (11,'Обзор Air Penguin','<p><img src=\"http://www.tooflya.com/assets/img/blog/jGDj3J0rkG.png\" alt=\"\" class=\"blog-img float-left\" />Сюжет как голивудском боевике - после глобального потепления лед треснул, и семья главного героя оказалась на разных льдинах. И вам, как заправскому супергерою, нужно воссоединиться с семьей, минуя врагов и препятствия.</p>\r\n<p>Air Penguin - весьма популярная игра для Android, о чем буквально таки кричит количество скачиваний - более 10 миллионов. Нам предстоит проходить уровни в роли синего пингвина. За игровую валюту можно приобрести розового или черного пингвина, или же белого медведя, что весьма странно - пингвины и белые медведи живут на разных полюсах...</p>•\r\n<p class=\"centered\"><img src=\"http://www.tooflya.com/assets/img/blog/jfdpbnk6zV.jpg\" alt=\"\" class=\"blog-img-center\" /></p>\r\n<p>Врагов в игре предостаточно - одни только касатки чего стоят...</p>\r\n<p class=\"centered\"><img src=\"http://www.tooflya.com/assets/img/blog/KeRZ56y1i6.jpg\" alt=\"\" class=\"blog-img-center\" /></p>\r\n<p>Но в игре есть и приятные моменты в виде бонусных элементов типа обезвреживания врагов или вспомогательных персонажей.</p>\r\n<p class=\"centered\"><img src=\"http://www.tooflya.com/assets/img/blog/S2s8qroTLj.jpg\" alt=\"\" class=\"blog-img-center\" /></p>\r\n\r\n\r\n<p>Передвигается наш персонаж тремя способами:\r\n<ul>\r\n<li>Перепрыгивает с льдины на льдину;</li>\r\n<li>Лавирует на черепахе между льдинами;</li>\r\n<li>Скользит по огромным льдинам на брюхе.</li>\r\n</ul>\r\n</p>\r\n<p class=\"centered\">\r\n<img src=\"http://www.tooflya.com/assets/img/blog/rwnPVgyhwu.jpg\" alt=\"\" class=\"blog-img-center\" />\r\n<img src=\"http://www.tooflya.com/assets/img/blog/nfvpQhURak.jpg\" alt=\"\" class=\"blog-img-center\" />\r\n</p>\r\n<p>На Google Play игра распространяется бесплатно, и в последнее время количество скачиваний лишь увеличивается. Это только подтверждает тот факт, что игра целиком и полностью заслуживает свою оценку - 4.4.</p>\r\n<p></p>\r\n<b>Разработчик:</b> Gamevil Inc.<br />\r\n<b>Цена:</b> бесплатно<br />\r\n<b>Жанр:</b> Arcade and Action<br />',2,1,'review-air-penguin','2012-10-24 09:13:33',1,1);
INSERT INTO `blog` VALUES (12,'Bubble Fun - наша новая, великолепная игра','<p><img src=\"http://www.tooflya.com/assets/img/blog/cdKb6qlz6J.png\" alt=\"\" class=\"blog-img float-left\" />Почти каждый из нас стрелял в детстве по птичкам из рогатки, хоть это и нехорошо... Но детство кончилось, а порой так хочется в него вернуться... Предлагаем вам сменить рогатки на телефоны, «снаряды» на жвачку, и давайте сбивать птичек!!!<p>\r\n<p>Bubble Fun — симулятор детства. Здесь все красочно и весело: птички, небо, жвачка... Задача в игре тоже детская — вам необходимо сбивать птичек шариками, надутыми из жвачки.</p>•\r\n<p>&nbsp;</p>\r\n<p>Можно надувать шарики любого размера, вот только еще и за запасом воздуха следить придется, поскольку его количество у вас ограничено. Да и попасть в птичек с каждым уровнем будет все сложнее и сложнее, ведь двигаться они буду все хаотичнее. Так же в игре вас ожидают разнообразные бонусы и плюшки, рассказывать о которых сейчас мы не будем — этой информацией мы поделимся ближе к дате релиза.</p>\r\n<p><img src=\"http://www.tooflya.com/assets/img/Bubble-Fun-Big-Banner.jpg\" alt=\"\" class=\"blog-img-center\" style=\"width: 700px;\" /></p>\r\n<p><b>Совсем скоро в Google Play!</b></p>',2,1,'bubble-fun-review','2012-10-24 05:24:22',1,1);
INSERT INTO `blog` VALUES (13,'Используем хуки в GIT на полную катушку или как же мы жили раньше','<p><img src=\"http://www.tooflya.com/assets/img/blog/V1tKmXuWfo.jpg\" alt=\"\" class=\"blog-img float-left\" />\r\nКак и во многих других системах контроля версий, в Git есть способ использовать пользовательские сценарии, в случае необходимости выполнения того или иного действия в определенной ситуации. Есть две группы этих, так называемых, хуков: <i>клиентские</i> и <i>серверные</i>. На клиентской стороне исполняются операции, такие как внесение изменений, слияние и т. д. Серверные хуки используются на Git сервере и представляют собой такие операции, как получение изменений. Вы можете использовать различные операции в тот или иной момент выполнения основных действий, об этом вы и узнаете далее.\r\n</p>•\r\n<h3>Начало использования хуков</h3>\r\n<p>\r\nВсе файлы с описанием сценариев хуков хранятся в подкаталоге <b>hooks</b> Git каталога. В большинстве проектов это <b>.git</b> директория. По умолчанию Git заполняет этот каталог кучей примеров сценариев, многие из которых являются полезными сами по себе, но они, в большей степени, являются примерами использования того или иного события. Все примеры написаны как скрипты, с некоторыми Perl вставками, но любой правильно названный скрипт будет работать нормально - вы можете писать их на <b>Ruby</b>, <b>Python</b> или что там у вас. Важно заметить, что с версии Git 1.6 все файлы называются правильно, но не являются исполняемыми.</p>\r\n<p>Для того чтобы использовать скрипт хука, поместите файл в подкаталог Git <b>hooks</b>, назовите его надлежащим образом и <b>проверьте является ли он исполняемым</b>. Начиная с этого момента, сценарий хука уже должен быть выполнен в определенной ситуации. Я расскажу о самых основных события, при которых вы можете использовать хуки, далее.</p>\r\n<h3>Клиентские хуки</h3>\r\n<p>Первые четыре хука имеют отношение к действию совершения внесения изменений <b>commit</b>. Сценарий хука <b>pre-commit</b> выполняется прежде, чем будет вызвана операция внесения изменений <b>commit</b>. Этот хук используется для проверки внесенных изменений, проверки кода, чтобы увидеть, не забыли ли вы что-то, выполнить тесты, либо внести какие-либо авто корректировки в коммит, добавить файлы, которые необходимо сгенерировать автоматически. Прерывание выполнения <i>(not return 0)</i> отменяет выполнение операции внесения изменений, но вы, конечно же, имеете возможность выполнить данную операцию без проверок с помощью команды <b>git commit --no-verify</b>. С помощью хука <b>pre-commit</b> вы можете выполнять такие полезные операции как, проверка стиля кода (запустить что-нибудь вкусненькое или что-то подобное), различные проверки, вырезать лишние пробелы (что, собственно, по-умолчанию этот хук и делает), сгенерировать соответствующую документацию на новые методы, либо экспортировать записи из базы данных.</p>\r\n<p>Давайте рассмотрим наиболее востребованный web-проектами сценарий, подходящий для этого хука: <b>миграцию базы данных</b>.</p>\r\n<p>Ситуация: есть некий web-проект, который вы разрабатываете на своей локальной машине и используете базу данных <i>(для примера я буду говорить о СУБД MySql)</i>. Кроме этого вы имеете production сервер, на котором \"крутится\" данный проект. Для синхронизации базы данных между этими двумя машинами очень удобно применять систему контроля версий и в частности хук <b>pre-commit</b>.</p>\r\n<p>Для реализации необходимого сценария нам необходимо выполнить несколько действий:</p>\r\n<ul>\r\n<li>1. Создадим файл сценария хука: <b>.git/hooks/pre-commit</b>;</li>\r\n<li>2. Назначим данный файл исполняемым, если требуется: <b>chmod +x .git/hooks/pre-commit</b>;</li>\r\n<li>\r\n3. Напишем сценарий для экспорта базы данных в файл, который в последующем будет добавлен в репозиторий:\r\n<div class=\"code\">\r\n#!/bin/sh<br />\r\nmysqldump -u root -p<i>Password</i> --skip-extended-insert <i>database_name</i> > /var/www/<i>project/dump</i>.sql<br />\r\ncd /var/www/<br />\r\ngit add <i>dump</i>.sql\r\necho \"Database dump was updated!\"\r\n</div>\r\n<p><b>Заметьте, что перед паролем пробела нет!</b></p>\r\n</li>\r\n</ul>\r\n<p>После этих действий хук <b>pre-commit</b> уже будет работать. Выполнив команду <b>git commit</b> <i>(или как вы там привыкли)</i>, в случае успеха вы увидите надпись <i>\"Database dump was updated!\"</i>. Это говорит о том, что база данных была экспортирована в файл <i>dump</i>.sql</p>\r\n<p>Но, к сожалению, для наших целей этого не достаточно. Кроме экспортирования дампа базы данных с девелоперской машины нам также необходимо импортировать измененные таблицы на production сервер. Делается это примерно также легко. На помощь нам приходит хук <b>post-merge</b>, сценарий которого выполняется после удачной операции слияния <i>(или успешной операции pull, неважно)</i>. Этот хук используется для колоссально огромного числа use-case\'ов от уведомления коллабораторов о выпуске новой версии до банальных проверок и импортов.</p>\r\n<p>Итак, выполним несколько действий для того, чтобы закончить настройку миграции нашей базы данных на production сервер <b>(Позволю себе уточнить, что данные операции необходимо выполнить дважды: на локальной машине и на сервере, дабы обеспечить кросс-миграцию)</b>:</p>\r\n<ul>\r\n<li>1. Создадим файл сценария хука: <b>.git/hooks/post-merge</b>;</li>\r\n<li>2. Назначим данный файл исполняемым, если требуется: <b>chmod +x .git/hooks/post-merge</b>;</li>\r\n<li>\r\n3. Напишем сценарий для импорта базы данных из файла, который в последующем будет добавлен в репозиторий:\r\n<div class=\"code\">\r\n#!/bin/sh<br />\r\nmysql -u root -p<i>Password</i> <i>database_name</i> < /var/www/<i>project/dump</i>.sql<br />\r\n</div>\r\n<p><b>Заметьте, что перед паролем пробела нет!</b></p>\r\n</li>\r\n</ul>\r\n<p>После этих действий хук <b>post-merge</b> также сразу будет работать. Выполнив команду <b>git pull</b> <i>(я забираю данные на production сервер из репозитория на github командой git pull)</i>, в случае успеха база данных будет импортирована.</p>\r\n<p>Вот так, за 5 минут мы настроили миграцию базы данных MySql на production сервер. Действия, которые помогут нам в работе, отлично вкладываются в хуки. Сценарии их работы ограничиваются только нашей фантазией. Например, совсем недавно была анонсирована программа, делающая фотографию программиста при каждом коммите  - получилась довольно забавная штуковина.</p>\r\n<h3>Другие клиентские хуки</h3>\r\n<p>Кроме хуков <b>pre-commit</b> и <b>post-merge</b> существуют еще несколько интересных хуков. Давайте их разберем.</p>\r\n<p>Сценарий хука <b>prepare-commit-msg</b> будет исполнен до запуска редактора сообщения, но после того, как стандартное сообщение будет сгенерировано. Это позволит вам отредактировать сообщение коммита до того как вы увидите стандартное. Данный хук принимает несколько параметров: путь к файлу, который содержит шаблон измененного сообщения, тип коммита, и SHA-1 коммита, к которому внесены изменения <i>(в случае если этот коммит носит fix характер другого коммита)</i>. Хук <b>prepare-commit-msg</b> не сильно полезен для обычных проектов, но в случае особого именования коммитов или использования <a href=\"http://github.com\">GitHub.com</a> <i>(типа Fix #115)</i> это довольно неплохая вещь.</p>\r\n<p>Еще один полезный хук <b>post-commit</b> выполняется после того, как процесс внесения изменений будет завершен. С помощью данного хука вы легко можете получить данные о последних изменениях, выполнив команду <b>git log -1 HEAD</b>, например. Хук <b>post-commit</b> чаще всего используется для каких-либо уведомлений и т. д.</p>\r\n<p>Хук <b>pre-rebase</b> исполняется перед стартом перемещения, операции rebase. Это очень полезный хук. Очень удобно уметь остановить перемещении при провале какой-либо проверки во время исполнения сценария хука и он это может! Действительно, стоит лишь выйти без ноля <i>(прервать)</i> выполнение сценария. Мы можем использовать данный хук для различных проверок или запрета перемещения коммитов, которые уже были синхронизированы с сервером.</p>\r\n<p>И, наконец-то, хук <b>post-checkout</b> стартует исполнение сценария после удачной операции <b>checkout</b>. Вы можете использовать его для корректной настройки вашего рабочего окружения после операции <b>checkout</b>, перемещать большие бинарные файлы, генерировать документацию или что-либо еще, требующее особого внимания.</p>\r\n<h3>Серверные хуки</h3>\r\n<p>В дополнение к клиентским , вы можете использовать несколько важных серверных хуков в качестве системного администрирования для обеспечения практически любого вида политики для вашего проекта. Эти сценарии выполняются до и после принятия изменений сервером. Предварительные <i>(pre)</i> хуки могут остановить выполнение команды, также как и описанные выше хуки. Кроме того можно настроить серверные сценарии на нажатие клавиш и общение с администратором по SSH.</p>\r\n<h3>pre-receive и post-receive хуки</h3>\r\n<p>В первую очередь запускается сценарий хука <b>pre-receive</b>, в момент получения изменений извне, но до того, как изменения будут внесены. Снова огромное поле для проверок, аутентификацией, реджектов и уведомлений. Кроме того можно использовать сценарий хука <b>post-receive</b> для реорганизации полученных изменений.</p>\r\n<p></p>\r\n<p>Как мы успели заметить хуки - очень крутая и полезная вещь. Конечно, я описал не все хуки и варианты их использования, по-этому рекомендую вам обратится к документации на досуге, но зато теперь вы знаете основу ;) <b>Правда я молодец? (;</b></p>\r\n<p><b>Покашечки!</b></p>',1,4,'using-hooks-in-git','2012-10-30 23:01:27',1,1);
INSERT INTO `blog` VALUES (14,'Music Hero Review','<p><img src=\"http://www.tooflya.com/assets/img/blog/kZ64Fmp7J8.png\" alt=\"\" class=\"blog-img float-left\" />Do you want to pick up a guitar and play your favorite song? Or become guitarist of your favorite band? All you need for this -  a phone with Android OS and the game Music Hero. Your task in the game is to get into the rhythm of the song. You can use built-in game composition or download them from your phone. Controlling is incredibly simple - you mast press the screen when the music disc is coming to the edge of the string. Hits are fixed by the counter that counts the number and quality of these hits.</p>•\r\n<p class=\"centered\">\r\n<img src=\"http://www.tooflya.com/assets/img/blog/KIG25UeRLp.jpg\" alt=\"\" class=\"blog-img-center\" />\r\n<img src=\"http://www.tooflya.com/assets/img/blog/2c7cZamSAH.jpg\" alt=\"\" class=\"blog-img-center\" />\r\n</p>\r\n<p>The game has three levels of difficulty. At a basic level you will play even the unknown song, but at the rest you’ll have to sweat even on your favorite tracks.</p>\r\n<p class=\"centered\"><img src=\"http://www.tooflya.com/assets/img/blog/uKFy1Xn0A9.jpg\" alt=\"\" class=\"blog-img-center\" /></p>\r\n<p>The graphics in the game worked so great that it seems that you are at the many thousands concert and you are its center. Pick up your phone and play your favorite song.</p>\r\n<p></p>\r\n<b>Developer:</b> Words Mobile<br />\r\n<b>Price:</b> Free<br />\r\n<b>Genre:</b> Casual<br />',2,1,'review-music-hero','2012-11-10 22:23:26',0,1);
INSERT INTO `blog` VALUES (15,'Обзор Music Hero','<p><img src=\"http://www.tooflya.com/assets/img/blog/kZ64Fmp7J8.png\" alt=\"\" class=\"blog-img float-left\" />Хотите взять в руки гитару и сыграть любимую песню? А побывать гитаристом любимой группы? Все что вам для этого понадобится, это телефон с Android и игра Music Hero. Ваша задача в игре — попадать в ритм песни. Можно использовать как встроенные в игру композиции, так и загружать имеющиеся на вашем телефоне. Управление невероятно простое — в момент, когда музыкальный диск подходит к краю струны, нажать на экран. Попадания фиксируются счетчиком, который считает количество и качество этих попаданий.</p>•\r\n<p class=\"centered\">\r\n<img src=\"http://www.tooflya.com/assets/img/blog/KIG25UeRLp.jpg\" alt=\"\" class=\"blog-img-center\" />\r\n<img src=\"http://www.tooflya.com/assets/img/blog/2c7cZamSAH.jpg\" alt=\"\" class=\"blog-img-center\" />\r\n</p>\r\n<p>В игре присутствует три уровня сложности. На начальном уровне можно сыграть даже незнакомую песню, а на остальных придется попотеть даже над любимыми композициями.</p>\r\n<p class=\"centered\"><img src=\"http://www.tooflya.com/assets/img/blog/uKFy1Xn0A9.jpg\" alt=\"\" class=\"blog-img-center\" /></p>\r\n<p>Графика в игре проработана настолько великолепно, что складывается впечатление будто находишься на многотысячном концерте и ты его центр. Возьмите свой телефон, и сыграйте любимую песню.</p>\r\n<p></p>\r\n<b>Разработчик:</b> Words Mobile<br />\r\n<b>Цена:</b> бесплатно<br />\r\n<b>Жанр:</b> Casual<br />',2,1,'review-music-hero','2012-11-10 22:24:52',1,1);
INSERT INTO `blog` VALUES (16,'Defender Zone Review','<p><img src=\"http://www.tooflya.com/assets/img/blog/FQLXHvGVHv.png\" alt=\"\" class=\"blog-img float-left\" />DZ - Excellent representative of the genre, though not very popular. I believe that this is truly a masterpiece and a worthy rival to the Defender by DroidHen. And now I will tell you why.</p>\r\n<p>In many games of this genre (and the Defender is no exception) there is only one map showing the gameplay. Maximum there are two or three maps that are different, usually just by the weather or the season. But in the DZ everything is different - two dozen of cards (but they all are available only in the paid version, in free version only three maps are available ), that are different from each other. There you have the forest, snow-covered mountain pass, and even on the surface of the volcano you can keep the defense. So, we have a great number of locations in the game, that certainly is a big plus.</p>•\r\n<p class=\"centered\"><img src=\"http://www.tooflya.com/assets/img/blog/W2fBBmoSyo.jpg\" alt=\"\" class=\"blog-img-center\" /></p>\r\n<p class=\"centered\"><img src=\"http://www.tooflya.com/assets/img/blog/CJ53YFdhUH.jpg\" alt=\"\" class=\"blog-img-center\" /></p>\r\n<p>Now about the arms. Weapons in the game are not so many - only 6 species. On the first level you have only two types of weapons - machine gun tower and missile system, but it is quite enough to stop the enemy. The rest of the weapons will appear as the game progresses, because nearly from the middle of the game begins a real hell, where you will never survive without the heavy weapons. Each weapon also has 4 stages prorolling, all of which increases the power and range of weapons destruction.</p>\r\n<p class=\"centered\"><img src=\"http://www.tooflya.com/assets/img/blog/CgLUsDlrEb.jpg\" alt=\"\" class=\"blog-img-center\" /></p>\r\n<p>Graphics and sound. The game was made by the reall professionals - top view, used in the game, is great. But the most important thing is that the graphics quality does not deteriorate while zooming. Sounds in the game are also on the highest level - great quality without delay or advance of the moment. And, importantly, the sounds correspond to military topics.</p>\r\n<p class=\"centered\"><img src=\"http://www.tooflya.com/assets/img/blog/aqxGDMbptz.jpg\" alt=\"\" class=\"blog-img-center\" /></p>\r\n<p class=\"centered\"><img src=\"http://www.tooflya.com/assets/img/blog/MfHj2CgrUp.jpg\" alt=\"\" class=\"blog-img-center\" /></p>\r\n<p>The game is available in four versions: Defender Zone, Defender Zone Lite, Defender Zone HD and Defender Zone HD Lite. They are different only in graphics quality, price and the number of levels.</p>\r\n<p></p>\r\n<b>Developer:</b> Artem Kotov<br />\r\n<b>Price:</b> $3<br />\r\n<b>Genre:</b> Arcade and Action<br />',2,1,'review-defender-zone','2012-11-10 22:29:25',0,1);
INSERT INTO `blog` VALUES (17,'Обзор Defender Zone','<p><img src=\"http://www.tooflya.com/assets/img/blog/FQLXHvGVHv.png\" alt=\"\" class=\"blog-img float-left\" />DZ — отличный представитель жанра, хоть и не очень популярный. Я считаю что это действительно шедевр и достойный соперник самому Defender от DroidHen. И сейчас я расскажу вам почему.</p>\r\n<p>Во многих играх подобного жанра (и Defender не исключение) есть всего одна карта, на которой происходит игровой процесс. Максимум - две или три карты, отличающиеся, как правило, только погодными условиями или временем года. Но в DZ все иначе — два десятка карт (правда, доступны они только в платной версии, в бесплатной доступно лишь три), абсолютно непохожих друг на друга. Тут вам и лес, и заснеженный горный перевал, и даже на поверхности вулкана можно держать оборону. В общем, локаций в игре великое множество, что безусловно является большим плюсом.</p>•\r\n<p class=\"centered\"><img src=\"http://www.tooflya.com/assets/img/blog/W2fBBmoSyo.jpg\" alt=\"\" class=\"blog-img-center\" /></p>\r\n<p class=\"centered\"><img src=\"http://www.tooflya.com/assets/img/blog/CJ53YFdhUH.jpg\" alt=\"\" class=\"blog-img-center\" /></p>\r\n<p>Теперь о вооружении. Его в игре не так много как карт — всего 6 видов. На первом уровне доступно всего два вида вооружения — пулеметная башня и ракетный комплекс, но и этого вполне достаточно чтобы остановить врага. Остальные виды оружия будут появляться по мере прохождения игры, ведь примерно с середины начинается такое пекло, в котором без тяжелого вооружения выжить просто невозможно. Но разнообразием вооружение не ограничивается. У каждого оружия есть еще и 4 этапа прокачки, каждый из которых увеличивает мощность оружия и дальность поражения.</p>\r\n<p class=\"centered\"><img src=\"http://www.tooflya.com/assets/img/blog/CgLUsDlrEb.jpg\" alt=\"\" class=\"blog-img-center\" /></p>\r\n<p>Графика и звуковое сопровождение. Над игрой работали действительно профессионалы — вид сверху, используемый в игре, великолепен. Но самое главное то, что качество графики нисколько не страдает при зумировании. Хотите - наслаждайтесь крахом ваших врагов вблизи, а хотите — отдалите камеру, чтоб осмотреть все свои владения. Звуки в игре тоже на высшем уровне — все качественно, без опозданий или опережений момента. И, что немаловажно, звуки соответствуют военной тематике.</p>\r\n<p class=\"centered\"><img src=\"http://www.tooflya.com/assets/img/blog/aqxGDMbptz.jpg\" alt=\"\" class=\"blog-img-center\" /></p>\r\n<p class=\"centered\"><img src=\"http://www.tooflya.com/assets/img/blog/MfHj2CgrUp.jpg\" alt=\"\" class=\"blog-img-center\" /></p>\r\n<p>Игра предлагается в четырех вариантах: Defender Zone, Defender Zone Lite, Defender Zone HD и Defender Zone HD Lite. Отличаются они только качеством графики, ценой и количеством уровней.</p>\r\n<p></p>\r\n<b>Разработчик:</b> Artem Kotov<br />\r\n<b>Цена:</b> $3<br />\r\n<b>Жанр:</b> Arcade and Action<br />',2,1,'review-defender-zone','2012-11-10 22:30:10',1,1);
INSERT INTO `blog` VALUES (18,'Kiwi Run Review','<p><img src=\"http://www.tooflya.com/assets/img/blog/VQ5xR3E7LZ.png\" alt=\"\" class=\"blog-img float-left\" />At that moment, there are many online games belong to the so-called genre \"runner\". Although, as a genre, these games do not stand out, and are determined in the Google Play as \"Arcade and Action\", but their characteristic feature is that the main character is constantly running (hence the definition of \"runner\"). The player also can only overcome the obstacles and collect bonuses. Management - jump, sometimes even the opportunity to sit down, to slip under the barrier.</p>•\r\n<p>\"Kiwi Run\" - a typical representative of the genre, very bright, colorful, in a word - lure game. The disadvantages can be attributed, perhaps, only in the inability to turn off the sound. But in general, the game is fully deserves its estimate 4.6, which it has on Google Play.</p>\r\n<p class=\"centered\"><img src=\"http://www.tooflya.com/assets/img/blog/xowpQAksZS.jpg\" alt=\"\" class=\"blog-img-center\" /></p>\r\n<p>The main character, as the name implies - kiwi bird who can not fly, but it can run and jump very well. Tully’s task (so call our character) is to run as much distance as it possible and collect the appropriate to the level set of objects - \"Nestable Set\", which includes from three to six items.</p>\r\n<p class=\"centered\"><img src=\"http://www.tooflya.com/assets/img/blog/JUM73YIhvK.jpg\" alt=\"\" class=\"blog-img-center\" /></p>\r\n<p>For every collected \"Nestable Set\" relies certain number of berries (which are game currency), which can be spent for upgrading bonuses. Also berries can be collected in the process in time of passing the level.</p>\r\n<p class=\"centered\"><img src=\"http://www.tooflya.com/assets/img/blog/PVORD3mcdd.jpg\" alt=\"\" class=\"blog-img-center\" /></p>\r\n<p>There are a number of bonuses in the - from saving by the turtle in the event of a fall to being able to fly a glider.</p>\r\n<p class=\"centered\"><img src=\"http://www.tooflya.com/assets/img/blog/D12lv9KMJa.jpg\" alt=\"\" class=\"blog-img-center\" /></p>\r\n<p>Kiwi is not able to fly, but tries hard. And if you hold down the jump button, Tully wil funny iterate legs, that allows you to \"fly\" a greater distance. After overcoming the distance of 700 meters bird becomes more rapid: its eyes narrowed and it strongly pressed to the ground. Lovers of the genre \"runner\" will certainly enjoy the game, and those who is not familiar with this genre, I suggest to start with this game.</p>\r\n<p><u>Pros</u>: colorful animation, sound physics, high-quality sound effects.<br />\r\n<u>Cons</u>: be careful! The game is constantly hanging in memory and generate the files on the SD card, which is not a clean.</p>\r\n<p></p>\r\n<b>Developer:</b> IcePop Beat<br />\r\n<b>Price:</b> Free<br />\r\n<b>Genre:</b> Arcade and Action<br />',2,1,'kiwi-run-review','2012-11-11 13:23:31',0,1);
INSERT INTO `blog` VALUES (19,'Обзор Kiwi Run','<p><img src=\"http://www.tooflya.com/assets/img/blog/VQ5xR3E7LZ.png\" alt=\"\" class=\"blog-img float-left\" />На данный момент в Интернете существует немало игр принадлежащих к так называемому жанру “runner”. Хотя как жанр эти игры не выделяются, а определяются в магазинах приложений как “Arcade and Action”, но их характерная черта в том, что главный герой постоянно бежит (отсюда и определение “runner”). Игроку же остается лишь преодолевать препятствия и собирать бонусы. Управление - прыжок, иногда еще и возможность присесть, чтоб проскользнуть под препятствием.</p>•\r\n<p>“Kiwi Run” - типичный представитель жанра, очень яркая, красочная, одним словом - завлекающая игра. К минусам можно отнести, пожалуй, только отсутствие возможности выключения звука. А в целом, игра полностью заслуживает свою оценку 4.6, которую получила на Google Play. </p>\r\n<p class=\"centered\"><img src=\"http://www.tooflya.com/assets/img/blog/xowpQAksZS.jpg\" alt=\"\" class=\"blog-img-center\" /></p>\r\n<p>Главный герой, как видно из названия - птичка киви, которая не умеет летать, но неплохо бегает и прыгает. Задача Tully (так зовут нашего персонажа) пробежать как можно большее расстояние и собрать соответствующий уровню комплект предметов - “Nestable Set”, в который входит от трех до шести предметов.</p>\r\n<p class=\"centered\"><img src=\"http://www.tooflya.com/assets/img/blog/JUM73YIhvK.jpg\" alt=\"\" class=\"blog-img-center\" /></p>\r\n<p>За сбор каждого “Nestable Set” полагается определенное количество ягод (они являются игровой валютой), которые можно потратить на апгрейд бонусов. Также ягоды можно собрать в процессе прохождения уровня.</p>\r\n<p class=\"centered\"><img src=\"http://www.tooflya.com/assets/img/blog/PVORD3mcdd.jpg\" alt=\"\" class=\"blog-img-center\" /></p>\r\n<p>Бонусов в игре немало - от спасения черепахой в случае падения, до возможности полетать на глайдере. </p>\r\n<p class=\"centered\"><img src=\"http://www.tooflya.com/assets/img/blog/D12lv9KMJa.jpg\" alt=\"\" class=\"blog-img-center\" /></p>\r\n<p>А после преодоления расстояния в 700 метров птичка приобретает более стремительный вид: у нее сужаются глаза и она сильнее прижимается к земле.\r\nИгра безусловно понравится любителям жанра “runner”, а тем кто с этим жанром не знаком, советую начать именно с этой игры. Киви хоть и не умеет летать, но очень старается. И если зажать кнопку прыжка, то Tully начнет забавно перебирать ножками, что позволяет “пролететь” большее расстояние.</p>\r\n<p><u>Плюсы</u>: красочная анимация, продуманная физика, качественные звуковые эффекты.<br />\r\n<u>Минусы</u>: будьте осторожны! Игра постоянно висит в памяти и генерирует непонятные файлы на SD карту, которые за собой не чистит.</p>\r\n<p></p>\r\n<b>Разработчик:</b> IcePop Beat<br />\r\n<b>Цена:</b> бесплатно<br />\r\n<b>Жанр:</b> Arcade and Action<br />',2,1,'kiwi-run-review','2012-11-11 13:23:35',1,1);
/*!40000 ALTER TABLE `blog` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `blog_classes`
--

DROP TABLE IF EXISTS `blog_classes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `blog_classes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cid` int(11) NOT NULL,
  `class` varchar(255) NOT NULL,
  `position` int(11) NOT NULL,
  `alias` varchar(150) NOT NULL,
  `language` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `cid` (`cid`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8 COMMENT='Table for the store blog categories.';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `blog_classes`
--

LOCK TABLES `blog_classes` WRITE;
/*!40000 ALTER TABLE `blog_classes` DISABLE KEYS */;
INSERT INTO `blog_classes` VALUES (1,1,'Reviews',0,'reviews',0);
INSERT INTO `blog_classes` VALUES (2,2,'News',1,'news',0);
INSERT INTO `blog_classes` VALUES (3,3,'Articles',2,'articles',0);
INSERT INTO `blog_classes` VALUES (4,4,'Technical side',3,'technical-side',0);
INSERT INTO `blog_classes` VALUES (5,5,'Graphics',4,'graphics',0);
INSERT INTO `blog_classes` VALUES (6,6,'Social Life',5,'social-life',0);
INSERT INTO `blog_classes` VALUES (7,1,'Обзоры',0,'reviews',1);
INSERT INTO `blog_classes` VALUES (8,2,'Новости',1,'news',1);
INSERT INTO `blog_classes` VALUES (9,3,'Статьи',1,'articles',1);
INSERT INTO `blog_classes` VALUES (10,4,'Техническая сторона',1,'technical-side',1);
INSERT INTO `blog_classes` VALUES (11,5,'Графика',1,'graphics',1);
INSERT INTO `blog_classes` VALUES (12,6,'Социальная жизнь',1,'social-life',1);
/*!40000 ALTER TABLE `blog_classes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `subscriptions`
--

DROP TABLE IF EXISTS `subscriptions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `subscriptions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mail` varchar(150) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COMMENT='Table for store subscriptions';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `subscriptions`
--

LOCK TABLES `subscriptions` WRITE;
/*!40000 ALTER TABLE `subscriptions` DISABLE KEYS */;
INSERT INTO `subscriptions` VALUES (1,'igor.mats@ya.ru','2012-09-29 11:56:12');
INSERT INTO `subscriptions` VALUES (2,'asd@asdasd.ru','2012-09-29 15:18:12');
INSERT INTO `subscriptions` VALUES (3,'dmitry.shane@gmail.com','2012-10-24 19:14:24');
INSERT INTO `subscriptions` VALUES (4,'anna.fomenko@tooflya.com','2012-10-24 19:14:59');
INSERT INTO `subscriptions` VALUES (5,'aleonnas@gmail.com','2012-10-24 19:52:01');
INSERT INTO `subscriptions` VALUES (6,'insuregent4ever@gmail.com','2012-10-24 20:07:28');
INSERT INTO `subscriptions` VALUES (7,'nirvana3038@mail.ru','2012-10-24 20:48:56');
INSERT INTO `subscriptions` VALUES (8,'wharin@yandex.ru','2012-10-25 03:05:17');
INSERT INTO `subscriptions` VALUES (9,'ffcar@rambler.ru','2012-10-25 15:19:50');
INSERT INTO `subscriptions` VALUES (10,'xye-mae-vzlom@kill.game','2012-10-30 15:25:51');
/*!40000 ALTER TABLE `subscriptions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tweets`
--

DROP TABLE IF EXISTS `tweets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tweets` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `text` varchar(140) NOT NULL,
  `image` varchar(155) NOT NULL,
  `date` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `text` (`text`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tweets`
--

LOCK TABLES `tweets` WRITE;
/*!40000 ALTER TABLE `tweets` DISABLE KEYS */;
INSERT INTO `tweets` VALUES (1,'\"Friday Event\", attempt number two...','https://si0.twimg.com/profile_images/2758898694/60afb282f1cff33c04c41fc18829f8bb_normal.png','2012-10-24 14:58:45');
INSERT INTO `tweets` VALUES (2,'Friday Event - the game made in the night from Friday to Monday...','https://si0.twimg.com/profile_images/2758898694/60afb282f1cff33c04c41fc18829f8bb_normal.png','2012-10-24 14:58:45');
INSERT INTO `tweets` VALUES (3,'World is crazy!!! imho','https://si0.twimg.com/profile_images/2758898694/60afb282f1cff33c04c41fc18829f8bb_normal.png','2012-10-24 14:58:45');
INSERT INTO `tweets` VALUES (4,'Soon you will see our website. After about an hour, if not sooner...','https://si0.twimg.com/profile_images/2758898694/60afb282f1cff33c04c41fc18829f8bb_normal.png','2012-10-24 19:02:29');
INSERT INTO `tweets` VALUES (5,'Our site is already running. Welcome :) http://t.co/wRl47tgQ','https://si0.twimg.com/profile_images/2758898694/60afb282f1cff33c04c41fc18829f8bb_normal.png','2012-10-30 14:09:34');
INSERT INTO `tweets` VALUES (6,'Russian version of our site is available. Try it :) \nhttp://t.co/9y3XxjSg','https://si0.twimg.com/profile_images/2758898694/60afb282f1cff33c04c41fc18829f8bb_normal.png','2012-10-30 16:26:07');
INSERT INTO `tweets` VALUES (7,'At the nearest time you\'ll see our awesome game - Bubble Fun.\nhttp://t.co/1JzF6SB8','https://si0.twimg.com/profile_images/2758898694/60afb282f1cff33c04c41fc18829f8bb_normal.png','2012-11-10 22:13:07');
INSERT INTO `tweets` VALUES (8,'New review about nice game. Try it :)\nhttp://t.co/tRCXwcB8\n#games #android #review','https://si0.twimg.com/profile_images/2758898694/60afb282f1cff33c04c41fc18829f8bb_normal.png','2012-11-11 15:43:14');
/*!40000 ALTER TABLE `tweets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tweets_update`
--

DROP TABLE IF EXISTS `tweets_update`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tweets_update` (
  `last` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tweets_update`
--

LOCK TABLES `tweets_update` WRITE;
/*!40000 ALTER TABLE `tweets_update` DISABLE KEYS */;
INSERT INTO `tweets_update` VALUES ('2012-11-13 11:03:42');
/*!40000 ALTER TABLE `tweets_update` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(35) NOT NULL,
  `surname` varchar(55) NOT NULL,
  `job` varchar(105) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='Table for stote users';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Igor','Mats','Tooflya Inc. CEO');
INSERT INTO `users` VALUES (2,'Anton','Korobsky','Tooflya Inc. PR');
INSERT INTO `users` VALUES (3,'Rostyslav','Pudlo','Tooflya Inc. Senior Developer');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2012-11-13 15:49:26
