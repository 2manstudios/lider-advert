<?php

// категории
$data = array(
    'Квартиры' => '1',
    'Дома. Дачи' => '2',
    'Земельные участки' => '3',
    'Коммерческая недвижимость' => '4',
    'Гаражи и паркинги' => '9000'
);

// операции
$data2 = array(
    '1' => array(
        '7'=>'Продажа',
        '8'=>'Аренда посуточно',
        '9'=>'Аренда долгосрочно',
    ),
    '2' => array(
       '10' => 'Продажа',
       '11' => 'Аренда',
    ),
    '3' => array(
        
    ),
    '4' => array(
        '64' => 'Продажа',
        '65' => 'Аренда'
    ),
    '9000' => array(
        '9001' => 'Продажа',
        '9002' => 'Аренда'
    )
);

// подкатегория
$udata = array(
    '64' => array(        
        '66' => 'Офисы',
        '67' => 'Магазины. Киоски. Торговые площади',
        '68' => 'Кафе. Рестораны. Бары. Клубы',
        '69' => 'Салоны красоты. Спортклубы',
        '70' => 'Гостиницы. Базы отдыха. Санатории',
        '71' => 'Автосервис. АЗС',
        '72' => 'Склады. Ангары',
        '73' => 'Производство. Имущественные комплексы',
        '74' => 'Здания',
        '75' => 'Действующий бизнес',
        '76' => 'Другие помещения',
    ),
    '65' => array(
        '77' => 'Офисы',
        '7700' => 'Аренда рабочих мест (co-working)',
        '78' => 'Магазины. Киоски. Торговые площади',
        '79' => 'Кафе. Рестораны. Бары. Клубы',
        '80' => 'Салоны красоты. Спортклубы',
        '81' => 'Гостиницы. Базы отдыха. Санатории',
        '82' => 'Автосервис. АЗС',
        '83' => 'Склады. Ангары',
        '84' => 'Производство. Имущественные комплексы',
        '85' => 'Здания',
        '86' => 'Действующий бизнес',
        '87' => 'Другие помещения',
    ),    
);

// регион
$data3 = array(
    '76' => array(
        '7601' => 'Киев',
        '7602' => 'Киевская обл.',
        '7603' => 'Винницкая обл.',
        '7604' => 'Волынская обл.',
        '898' => 'Днепропетровск',
        '7605' => 'Днепропетровская обл.',
        '7606' => 'Донецкая обл.',
        '969' => 'Житомир',
        '7607' => 'Житомирская обл.',
        '7608' => 'Закарпатская обл.',
        '7609' => 'Запорожская обл.',
        '7610' => 'Ивано-Франковская обл.',
        '7611' => 'Кировоградская обл.',
        '7612' => 'Крым',
        '7613' => 'Луганская обл.',
        '7614' => 'Львовская обл.',
        '7615' => 'Николаевская обл.',
        '870' => 'Одесса',
        '7616' => 'Одесская обл.',
        '7617' => 'Полтавская обл.',
        '7618' => 'Ровенская обл.',
        '7619' => 'Сумская обл.',
        '7620' => 'Тернопольская обл.',
        '998' => 'Харьков',
        '7621' => 'Харьковская обл.',
        '7622' => 'Херсонская обл.',
        '7623' => 'Хмельницкая обл.',
        '7624' => 'Черкасская обл.',
        '7625' => 'Черниговская обл.',
        '7626' => 'Черновицкая обл.',
    ),
    '75' => array(
        '7501' => 'Киев',
        '7502' => 'Киевская обл.',
        '7503' => 'Винницкая обл.',
        '7504' => 'Волынская обл.',
        '897' => 'Днепропетровск',
        '7505' => 'Днепропетровская обл.',
        '7506' => 'Донецкая обл.',
        '968' => 'Житомир',
        '7507' => 'Житомирская обл.',
        '7508' => 'Закарпатская обл.',
        '7509' => 'Запорожская обл.',
        '7510' => 'Ивано-Франковская обл.',
        '7511' => 'Кировоградская обл.',
        '7512' => 'Крым',
        '7513' => 'Луганская обл.',
        '7514' => 'Львовская обл.',
        '7515' => 'Николаевская обл.',
        '869' => 'Одесса',
        '7516' => 'Одесская обл.',
        '7517' => 'Полтавская обл.',
        '7518' => 'Ровенская обл.',
        '7519' => 'Сумская обл.',
        '7520' => 'Тернопольская обл.',
        '997' => 'Харьков',
        '7521' => 'Харьковская обл.',
        '7522' => 'Херсонская обл.',
        '7523' => 'Хмельницкая обл.',
        '7524' => 'Черкасская обл.',
        '7525' => 'Черниговская обл.',
        '7526' => 'Черновицкая обл.',
    ),
    '74' => array(
        '7401' => 'Киев',
        '7402' => 'Киевская обл.',
        '7403' => 'Винницкая обл.',
        '7404' => 'Волынская обл.',
        '896' => 'Днепропетровск',
        '7405' => 'Днепропетровская обл.',
        '7406' => 'Донецкая обл.',
        '967' => 'Житомир',
        '7407' => 'Житомирская обл.',
        '7408' => 'Закарпатская обл.',
        '7409' => 'Запорожская обл.',
        '7410' => 'Ивано-Франковская обл.',
        '7411' => 'Кировоградская обл.',
        '7412' => 'Крым',
        '7413' => 'Луганская обл.',
        '7414' => 'Львовская обл.',
        '7415' => 'Николаевская обл.',
        '868' => 'Одесса',
        '7416' => 'Одесская обл.',
        '7417' => 'Полтавская обл.',
        '7418' => 'Ровенская обл.',
        '7419' => 'Сумская обл.',
        '7420' => 'Тернопольская обл.',
        '996' => 'Харьков',
        '7421' => 'Харьковская обл.',
        '7422' => 'Херсонская обл.',
        '7423' => 'Хмельницкая обл.',
        '7424' => 'Черкасская обл.',
        '7425' => 'Черниговская обл.',
        '7426' => 'Черновицкая обл.', 
    ),
    '73' => array(        
        '7301' => 'Киев',
        '7302' => 'Киевская обл.',
        '7303' => 'Винницкая обл.',
        '7304' => 'Волынская обл.',
        '895' => 'Днепропетровск',
        '7305' => 'Днепропетровская обл.',
        '7306' => 'Донецкая обл.',
        '966' => 'Житомир',
        '7307' => 'Житомирская обл.',
        '7308' => 'Закарпатская обл.',
        '7309' => 'Запорожская обл.',
        '7310' => 'Ивано-Франковская обл.',
        '7311' => 'Кировоградская обл.',
        '7312' => 'Крым',
        '7313' => 'Луганская обл.',
        '7314' => 'Львовская обл.',
        '7315' => 'Николаевская обл.',
        '867' => 'Одесса',
        '7316' => 'Одесская обл.',
        '7317' => 'Полтавская обл.',
        '7318' => 'Ровенская обл.',
        '7319' => 'Сумская обл.',
        '7320' => 'Тернопольская обл.',
        '995' => 'Харьков',
        '7321' => 'Харьковская обл.',
        '7322' => 'Херсонская обл.',
        '7323' => 'Хмельницкая обл.',
        '7324' => 'Черкасская обл.',
        '7325' => 'Черниговская обл.',
        '7326' => 'Черновицкая обл.',
    ),
    '72' => array(
        '7201' => 'Киев',
        '7202' => 'Киевская обл.',
        '7203' => 'Винницкая обл.',
        '7204' => 'Волынская обл.',
        '894' => 'Днепропетровск',
        '7205' => 'Днепропетровская обл.',
        '7206' => 'Донецкая обл.',
        '965' => 'Житомир',
        '7207' => 'Житомирская обл.',
        '7208' => 'Закарпатская обл.',
        '7209' => 'Запорожская обл.',
        '7210' => 'Ивано-Франковская обл.',
        '7211' => 'Кировоградская обл.',
        '7212' => 'Крым',
        '7213' => 'Луганская обл.',
        '7214' => 'Львовская обл.',
        '7215' => 'Николаевская обл.',
        '866' => 'Одесса',
        '7216' => 'Одесская обл.',
        '7217' => 'Полтавская обл.',
        '7218' => 'Ровенская обл.',
        '7219' => 'Сумская обл.',
        '7220' => 'Тернопольская обл.',
        '994' => 'Харьков',
        '7221' => 'Харьковская обл.',
        '7222' => 'Херсонская обл.',
        '7223' => 'Хмельницкая обл.',
        '7224' => 'Черкасская обл.',
        '7225' => 'Черниговская обл.',
        '7226' => 'Черновицкая обл.',
    ),
    '71' => array(
        '7101' => 'Киев',
        '7102' => 'Киевская обл.',
        '7103' => 'Винницкая обл.',
        '7104' => 'Волынская обл.',
        '893' => 'Днепропетровск',
        '7105' => 'Днепропетровская обл.',
        '7106' => 'Донецкая обл.',
        '964' => 'Житомир',
        '7107' => 'Житомирская обл.',
        '7108' => 'Закарпатская обл.',
        '7109' => 'Запорожская обл.',
        '7110' => 'Ивано-Франковская обл.',
        '7111' => 'Кировоградская обл.',
        '7112' => 'Крым',
        '7113' => 'Луганская обл.',
        '7114' => 'Львовская обл.',
        '7115' => 'Николаевская обл.',
        '865' => 'Одесса',
        '7116' => 'Одесская обл.',
        '7117' => 'Полтавская обл.',
        '7118' => 'Ровенская обл.',
        '7119' => 'Сумская обл.',
        '7120' => 'Тернопольская обл.',
        '993' => 'Харьков',
        '7121' => 'Харьковская обл.',
        '7122' => 'Херсонская обл.',
        '7123' => 'Хмельницкая обл.',
        '7124' => 'Черкасская обл.',
        '7125' => 'Черниговская обл.',
        '7126' => 'Черновицкая обл.',
    ),
    '70' => array(
        '7001' => 'Киев',
        '7002' => 'Киевская обл.',
        '7003' => 'Винницкая обл.',
        '7004' => 'Волынская обл.',
        '892' => 'Днепропетровск',
        '7005' => 'Днепропетровская обл.',
        '7006' => 'Донецкая обл.',
        '963' => 'Житомир',
        '7007' => 'Житомирская обл.',
        '7008' => 'Закарпатская обл.',
        '7009' => 'Запорожская обл.',
        '7010' => 'Ивано-Франковская обл.',
        '7011' => 'Кировоградская обл.',
        '7012' => 'Крым',
        '7013' => 'Луганская обл.',
        '7014' => 'Львовская обл.',
        '7015' => 'Николаевская обл.',
        '863' => 'Одесса',
        '7016' => 'Одесская обл.',
        '7017' => 'Полтавская обл.',
        '7018' => 'Ровенская обл.',
        '7019' => 'Сумская обл.',
        '7020' => 'Тернопольская обл.',
        '992' => 'Харьков',
        '7021' => 'Харьковская обл.',
        '7022' => 'Херсонская обл.',
        '7023' => 'Хмельницкая обл.',
        '7024' => 'Черкасская обл.',
        '7025' => 'Черниговская обл.',
        '7026' => 'Черновицкая обл.',
    ),
    '69' => array(
        '6901' => 'Киев',
        '6902' => 'Киевская обл.',
        '6903' => 'Винницкая обл.',
        '6904' => 'Волынская обл.',
        '891' => 'Днепропетровск',
        '6905' => 'Днепропетровская обл.',
        '6906' => 'Донецкая обл.',
        '962' => 'Житомир',
        '6907' => 'Житомирская обл.',
        '6908' => 'Закарпатская обл.',
        '6909' => 'Запорожская обл.',
        '6910' => 'Ивано-Франковская обл.',
        '6911' => 'Кировоградская обл.',
        '6912' => 'Крым',
        '6913' => 'Луганская обл.',
        '6914' => 'Львовская обл.',
        '6915' => 'Николаевская обл.',
        '864' => 'Одесса',
        '6916' => 'Одесская обл.',
        '6917' => 'Полтавская обл.',
        '6918' => 'Ровенская обл.',
        '6919' => 'Сумская обл.',
        '6920' => 'Тернопольская обл.',
        '991' => 'Харьков',
        '6921' => 'Харьковская обл.',
        '6922' => 'Херсонская обл.',
        '6923' => 'Хмельницкая обл.',
        '6924' => 'Черкасская обл.',
        '6925' => 'Черниговская обл.',
        '6926' => 'Черновицкая обл.',
    ),
    '68' => array(
        '6801' => 'Киев',
        '6802' => 'Киевская обл.',
        '6803' => 'Винницкая обл.',
        '6804' => 'Волынская обл.',
        '890' => 'Днепропетровск',
        '6805' => 'Днепропетровская обл.',
        '6806' => 'Донецкая обл.',
        '961' => 'Житомир',
        '6807' => 'Житомирская обл.',
        '6808' => 'Закарпатская обл.',
        '6809' => 'Запорожская обл.',
        '6810' => 'Ивано-Франковская обл.',
        '6811' => 'Кировоградская обл.',
        '6812' => 'Крым',
        '6813' => 'Луганская обл.',
        '6814' => 'Львовская обл.',
        '6815' => 'Николаевская обл.',
        '862' => 'Одесса',
        '6816' => 'Одесская обл.',
        '6817' => 'Полтавская обл.',
        '6818' => 'Ровенская обл.',
        '6819' => 'Сумская обл.',
        '6820' => 'Тернопольская обл.',
        '990' => 'Харьков',
        '6821' => 'Харьковская обл.',
        '6822' => 'Херсонская обл.',
        '6823' => 'Хмельницкая обл.',
        '6824' => 'Черкасская обл.',
        '6825' => 'Черниговская обл.',
        '6826' => 'Черновицкая обл.',
    ),
    '67' => array(
        '6701' => 'Киев',
        '6702' => 'Киевская обл.',
        '6703' => 'Винницкая обл.',
        '6704' => 'Волынская обл.',
        '889' => 'Днепропетровск',
        '6705' => 'Днепропетровская обл.',
        '6706' => 'Донецкая обл.',
        '960' => 'Житомир',
        '6707' => 'Житомирская обл.',
        '6708' => 'Закарпатская обл.',
        '6709' => 'Запорожская обл.',
        '6710' => 'Ивано-Франковская обл.',
        '6711' => 'Кировоградская обл.',
        '6712' => 'Крым',
        '6713' => 'Луганская обл.',
        '6714' => 'Львовская обл.',
        '6715' => 'Николаевская обл.',
        '861' => 'Одесса',
        '6716' => 'Одесская обл.',
        '6717' => 'Полтавская обл.',
        '6718' => 'Ровенская обл.',
        '6719' => 'Сумская обл.',
        '6720' => 'Тернопольская обл.',
        '989' => 'Харьков',
        '6721' => 'Харьковская обл.',
        '6722' => 'Херсонская обл.',
        '6723' => 'Хмельницкая обл.',
        '6724' => 'Черкасская обл.',
        '6725' => 'Черниговская обл.',
        '6726' => 'Черновицкая обл.',
    ),
    '66' => array(
        '6601' => 'Киев',
        '6602' => 'Киевская обл.',
        '6603' => 'Винницкая обл.',
        '6604' => 'Волынская обл.',
        '888' => 'Днепропетровск',
        '6605' => 'Днепропетровская обл.',
        '6606' => 'Донецкая обл.',
        '959' => 'Житомир',
        '6607' => 'Житомирская обл.',
        '6608' => 'Закарпатская обл.',
        '6609' => 'Запорожская обл.',
        '6610' => 'Ивано-Франковская обл.',
        '6611' => 'Кировоградская обл.',
        '6612' => 'Крым',
        '6613' => 'Луганская обл.',
        '6614' => 'Львовская обл.',
        '6615' => 'Николаевская обл.',
        '860' => 'Одесса',
        '6616' => 'Одесская обл.',
        '6617' => 'Полтавская обл.',
        '6618' => 'Ровенская обл.',
        '6619' => 'Сумская обл.',
        '6620' => 'Тернопольская обл.',
        '988' => 'Харьков',
        '6621' => 'Харьковская обл.',
        '6622' => 'Херсонская обл.',
        '6623' => 'Хмельницкая обл.',
        '6624' => 'Черкасская обл.',
        '6625' => 'Черниговская обл.',
        '6626' => 'Черновицкая обл.',
    ),
    '9002' => array(
        '9200' => 'Киев',
        '9201' => 'Киевская обл.',
        '9202' => 'Винницкая обл.',
        '9203' => 'Волынская обл.',
        '9204' => 'Днепропетровск',
        '9205' => 'Днепропетровская обл.',
        '9206' => 'Донецкая обл.',
        '982' => 'Житомир',
        '9207' => 'Житомирская обл.',
        '9208' => 'Закарпатская обл.',
        '9209' => 'Запорожская обл.',
        '9210' => 'Ивано-Франковская обл.',
        '9211' => 'Кировоградская обл.',
        '9212' => 'Крым',
        '9213' => 'Луганская обл.',
        '9214' => 'Львовская обл.',
        '9215' => 'Николаевская обл.',
        '9216' => 'Одесса',
        '9217' => 'Одесская обл.',
        '9218' => 'Полтавская обл.',
        '9219' => 'Ровенская обл.',
        '9220' => 'Сумская обл.',
        '9221' => 'Тернопольская обл.',
        '1011' => 'Харьков',
        '9222' => 'Харьковская обл.',
        '9223' => 'Херсонская обл.',
        '9224' => 'Хмельницкая обл.',
        '9225' => 'Черкасская обл.',
        '9226' => 'Черниговская обл.',
        '9227' => 'Черновицкая обл.',
    ),
    '9001' => array(
        '9100' => 'Киев',
        '9101' => 'Киевская обл.',
        '9102' => 'Винницкая обл.',
        '9103' => 'Волынская обл.',
        '9104' => 'Днепропетровск',
        '9105' => 'Днепропетровская обл.',
        '9106' => 'Донецкая обл.',
        '981' => 'Житомир',
        '9107' => 'Житомирская обл.',
        '9108' => 'Закарпатская обл.',
        '9109' => 'Запорожская обл.',
        '9110' => 'Ивано-Франковская обл.',
        '9111' => 'Кировоградская обл.',
        '9112' => 'Крым',
        '9113' => 'Луганская обл.',
        '9114' => 'Львовская обл.',
        '9115' => 'Николаевская обл.',
        '9116' => 'Одесса',
        '9117' => 'Одесская обл.',
        '9118' => 'Полтавская обл.',
        '9119' => 'Ровенская обл.',
        '9120' => 'Сумская обл.',
        '9121' => 'Тернопольская обл.',
        '1010' => 'Харьков',
        '9122' => 'Харьковская обл.',
        '9123' => 'Херсонская обл.',
        '9124' => 'Хмельницкая обл.',
        '9125' => 'Черкасская обл.',
        '9126' => 'Черниговская обл.',
        '9127' => 'Черновицкая обл.',        
    ),
    '11' => array(
        '226' => 'Киев',
        '227' => 'Киевская обл.',
        '228' => 'Винницкая обл.',
        '229' => 'Волынская обл.',
        '886' => 'Днепропетровск',
        '230' => 'Днепропетровская обл.',
        '231' => 'Донецкая обл.',
        '957' => 'Житомир',
        '232' => 'Житомирская обл.',
        '233' => 'Закарпатская обл.',
        '234' => 'Запорожская обл.',
        '235' => 'Ивано-Франковская обл.',
        '236' => 'Кировоградская обл.',
        '237' => 'Крым',
        '238' => 'Луганская обл.',
        '239' => 'Львовская обл.',
        '240' => 'Николаевская обл.',
        '858' => 'Одесса',
        '241' => 'Одесская обл.',
        '242' => 'Полтавская обл.',
        '243' => 'Ровенская обл.',
        '244' => 'Сумская обл.',
        '245' => 'Тернопольская обл.',
        '986' => 'Харьков',
        '246' => 'Харьковская обл.',
        '247' => 'Херсонская обл.',
        '248' => 'Хмельницкая обл.',
        '249' => 'Черкасская обл.',
        '250' => 'Черниговская обл.',
        '251' => 'Черновицкая обл.',
    ),
    '10' => array(
        '165' => 'Киев',
        '166' => 'Киевская обл.',
        '167' => 'Винницкая обл.',
        '168' => 'Волынская обл.',
        '885' => 'Днепропетровск',
        '169' => 'Днепропетровская обл.',
        '170' => 'Донецкая обл.',
        '956' => 'Житомир',
        '171' => 'Житомирская обл.',
        '172' => 'Закарпатская обл.',
        '173' => 'Запорожская обл.',
        '174' => 'Ивано-Франковская обл.',
        '175' => 'Кировоградская обл.',
        '176' => 'Крым',
        '177' => 'Луганская обл.',
        '178' => 'Львовская обл.',
        '179' => 'Николаевская обл.',
        '857' => 'Одесса',
        '180' => 'Одесская обл.',
        '181' => 'Полтавская обл.',
        '182' => 'Ровенская обл.',
        '183' => 'Сумская обл.',
        '184' => 'Тернопольская обл.',
        '985' => 'Харьков',
        '185' => 'Харьковская обл.',
        '186' => 'Херсонская обл.',
        '187' => 'Хмельницкая обл.',
        '188' => 'Черкасская обл.',
        '189' => 'Черниговская обл.',
        '190' => 'Черновицкая обл.',
    ),
    '9' => array(
        '53' => 'Другие города Украины',
        '51' => 'Киев',
        '52' => 'Киевская обл.',
        '930' => 'Винницкая обл.',
        '931' => 'Волынская обл.',
        '884' => 'Днепропетровск',
        '932' => 'Днепропетровская обл.',
        '933' => 'Донецкая обл.',
        '958' => 'Житомир',
        '934' => 'Житомирская обл.',
        '935' => 'Закарпатская обл.',
        '936' => 'Запорожская обл.',
        '937' => 'Ивано-Франковская обл.',
        '938' => 'Кировоградская обл.',
        '939' => 'Крым',
        '940' => 'Луганская обл.',
        '941' => 'Львовская обл.',
        '942' => 'Николаевская обл.',
        '855' => 'Одесса',
        '943' => 'Одесская обл.',
        '944' => 'Полтавская обл.',
        '945' => 'Ровенская обл.',
        '946' => 'Сумская обл.',
        '947' => 'Тернопольская обл.',
        '987' => 'Харьков',
        '948' => 'Харьковская обл.',
        '949' => 'Херсонская обл.',
        '950' => 'Хмельницкая обл.',
        '951' => 'Черкасская обл.',
        '952' => 'Черниговская обл.',
        '953' => 'Черновицкая обл.',
    ),
    '8' => array(
        '38' => 'Киев',
        '39' => 'Киевская обл.',
        '830' => 'Винница',
        '883' => 'Днепропетровск',
        '832' => 'Днепропетровская обл.',
        '833' => 'Донецк',
        '834' => 'Житомир',
        '835' => 'Закарпатская обл.',
        '836' => 'Запорожье',
        '837' => 'Ивано-Франковск',
        '838' => 'Кировоград',
        '839' => 'Крым',
        '840' => 'Луганск',
        '831' => 'Луцк',
        '841' => 'Львов',
        '842' => 'Николаев',
        '843' => 'Одесса',
        '856' => 'Одесская обл.',
        '844' => 'Полтава',
        '845' => 'Ровно',
        '846' => 'Сумы',
        '847' => 'Тернополь',
        '848' => 'Харьков',
        '8821' => 'Харьковская обл.',
        '849' => 'Херсон',
        '850' => 'Хмельницкий',
        '851' => 'Черкассы',
        '852' => 'Чернигов',
        '853' => 'Черновцы',
    ),
    '7' => array(
        '129' => 'Киев',
        '130' => 'Киевская обл.',
        '131' => 'Винницкая обл.',
        '132' => 'Волынская обл.',
        '882' => 'Днепропетровск',
        '133' => 'Днепропетровская обл.',
        '134' => 'Донецкая обл.',
        '955' => 'Житомир',
        '135' => 'Житомирская обл.',
        '136' => 'Закарпатская обл.',
        '137' => 'Запорожская обл.',
        '138' => 'Ивано-Франковская обл.',
        '139' => 'Кировоградская обл.',
        '140' => 'Крым',
        '141' => 'Луганская обл.',
        '142' => 'Львовская обл.',
        '143' => 'Николаевская обл.',
        '854' => 'Одесса',
        '144' => 'Одесская обл.',
        '145' => 'Полтавская обл.',
        '146' => 'Ровенская обл.',
        '147' => 'Сумская обл.',
        '148' => 'Тернопольская обл.',
        '984' => 'Харьков',
        '149' => 'Харьковская обл.',
        '150' => 'Херсонская обл.',
        '151' => 'Хмельницкая обл.',
        '152' => 'Черкасская обл.',
        '153' => 'Черниговская обл.',
        '154' => 'Черновицкая обл.',
    )
);

// район
$data4 = array(
    '51' => array(
        '54' => 'Голосеевский р-н',
        '55' => 'Дарницкий р-н',
        '56' => 'Деснянский р-н',
        '57' => 'Днепровский р-н',
        '58' => 'Оболонский р-н',
        '59' => 'Печерский р-н',
        '60' => 'Подольский р-н',
        '61' => 'Святошинский р-н',
        '62' => 'Соломенский р-н',
        '63' => 'Шевченковский р-н',
    ),
);

?>
