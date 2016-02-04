<?php
/**
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; under version 2
 * of the License (non-upgradable).
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
 *
 * Copyright (c) 2014 (original work) Open Assessment Technologies SA;
 *
 */
namespace jbout\boutTools\model\itemTransformation;

use oat\tao\model\media\sourceStrategy\HttpSource;
use oat\oatbox\action\Action;
use common_report_Report as Report;

class Obfuscate implements Action {
    
    private static $replacement = "何ラ撃夜ヱロ国振クタケ要間入われまし毎葉レべし内確レタヘワ浸督けぽまた稿禁跡のくごレ内室ノ上囲あょんゃ村43体気ヨチ最史ン敗情スほざゃ話戦ヘ画海謙興布トあるし。検タ政表藤竹くや低児ネオユホ日告トっ書真せりど聞企オ黒田ろ勤囲ぐくえで都72快だッよざ専79過73右ぎちつけ川刺ち。更タマ住場販ト図印ー写雇レ生太ぶべン施暮ム想芸クぱラっ件同タセノ様36面引キ他様質イクほ。広オナ属室天女クりがぶ質必ヒレオホ歌指じラー貼当や森転シツ処名ソホ者国書ッぐぼま厳印せぐ暮孝興はめに。係るぽ箕7度間ニセアキ明育づび出4日ゆ中田せ間禁神容スヱ治丸のふほ区多っべわ紙独ルニヱマ形続フユテ福円づげらが西善ごっつ備10社丹庄弥げ。半るぎれぽ多目むぴ産5手ツメ領白サリ慎留6陛入ぶふスお予端カ解平むぱけラ走法スソエ連伸ひろ治賢拍繁貫く。席理ンれ問返子おーさ質国リなッそ勢喪託ひ性頭ちゃン両作済ミア速度役ヨヒニフ情風ヘヤシ開下ーぜ芸山クオソ施約ねめ機画ヒウナ禁民みべ氷90掴ンまゆリ淋具近懲勤へ。死ヒルセユ樹緊ノヨナホ端帰カ塵慮こイ公宣よう無70北政ヲル鳩育ナ報止計え権都ロニトヤ彦航アヒワ苦中畑がんむま絶行よ導5点ッこ農能ごにりほ国去インゆ。67告ゆのー海2模ロウモホ貿村ぜ番社改ゆぽま踏松キテ講意コムオ祝急所総いかえも調論明トとおげ。談タキニ来庫じとほ合台ミル建大んトら翌味べ新校ユ乗書ドるフ待航ぶにぞお報6証リト政子にざえ節龍どれ心波ぱら真供訪浦きぜろさ。変ホヨフ万9美ユシハヲ傷自ヱニコモ受他ゃ新是ム所算信ちべ来施がル容林声がぼろル専宣テコ情9方医たド県無ぽこッじ統朝ノ地真ソエセヤ面総三ヤ井開且ンで。得も転暮ヒケ覧31速多ホヘシロ君率フ包社ぜよど供道ラサ齢性ヨタウ視予アリロ安男ヲイヒ説験函ぴわす際康だラか。課けじる芝東ユセルハ南有キヲ係印にだせ算仕国流てつぼら助6台座そイっぴ受標俳にぽ止写ワ図術たい質文イぽ詳定テケサオ読初画込掃へ。6景はゆ村退げラ触80迷イン針情ぞはほゆ車5理イ土川がとしま芸首容ヘソスヤ問討エコ額町あ経川撃カヘア図一ッぱおも型上イソユメ変与あふくぽ。全そくゆめ春普ロ観生れぞこ話局ょはぽ書幸ク成幸クチケ幅2辞ル大東リぐ初猶マヒフ出版親ゅ安次べこがド能新ん速権あぎり選付だ提空梅ツア魅策ユ投23僚弱招い。原礼しゆ検購ハモネヘ載賞ロカラ着白らと厘月げつ全定コ負者っげト釣葬者にの節97験ハツ失思41立ふず辞量リまで江道で止無ソホ棋歩重抑担黒づに。少全なばよい書私ルマロス連替ヘ複記セマシ感策ごむゅれ平図色でめ壁記月谷渡単ぼず写58治は関胡マノモ化89底ツロヱ勤分げるて情信く権合兼なず。限みイけ住問約セマ何過シ掲併はけばり的裁か関箙だしが取済ニワネマ旨9警モ主月カレ社8話で干側質だく争宿ソ正暮むんぐ異無オサル役亜才滅ぶぽ。客カ決左町ハ本由シケク術5事紀初画者ぶやそ投官ル和速業ドだこ浦案改トワテネ社好びレ内断こレばす満面コサヨ供主べド。祝他ヨメ熊台枚ユ災者ヘ団方イヘワテ会常フ刊3消ミカアニ事直わすての写地ヲセホル購7遺モ候締ク京夕罪佐因ぐ。無みでよ成講きづでー観択ナシ質思へ断増てね介脂こぱ阻4募っげゆみ護澤ぶぞさべ化者ねざーぽ拳開んと毎協ッフを編開ずイせ阪舞レヤニ整収万ぞ。択やひト末平ぴレ事投争たう裁能ずづぜ生半これわ網望ヨオホ撮細野ホ部給びだフ重江り県有影オツヲ太界ずル人願にッのざ。座闘ナ業部テマ係雄ニヱ台5読ネイモム王川終ツ済歳ハヱタチ倒法ミ代5高わてほ河黒べひむ前触止ヲ画難イ社向へぞくち川帯反念ばちッ。12購別イッ断教めぶんら争身ホ囲女ばぐぽ付写あもち道辺応をょレ長新こをラた告志スオネア本53普なょさい周福式ソサシ学脱四登副おに。書ヒテ大7報フスオ瀬渡き球散ニサフ極苦そみこへ縄全ヌリ掲7委ロコヒケ中読クぱ継大ル作界ヲホテリ種集雪アル渡面らとやば本百イ催丼冨奔彬ぱもッざ。目ル加宿士び素主橋タスカヲ生止月キネトラ民職ヱコシ継傷必が病逃じで統管クスマム容都キセ食陸フす滋易ぱきゃ。思ぐよわこ満二けと東施わ央69情ぜ際造けた表幼ほめ件2集ーへ口毎ヤア春課世こ竹7引概ふんけか掛写社切由村根ス";
    //private static $replacement = "D'Pan Stréi un rëm, räich iweral Dauschen bei no. Ké rëm Bänk bléit gehéiert, der gëtt schéinen Kolrettchen vu, d'Beem duerch si ass. Derfir blëtzen och ké, vu wou séngt d'Wéën. Soubal blëtzen da dan, fu sou hirem Milliounen, Stieren heemlech d'Kàchen hu déi. Kléder schnéiwäiss gei ze, Riesen beschte jo hie, op dir Heck aremt d'Leit. Heck Frot d'Wéën ké déi. Méi geet bereet d'Loft mä, ke den Ierd schéinen d'Hiezer. Zum an gutt lait blëtzen, ke sech virun Himmel och, rei fu Biereg d'Pied schnéiwäiss. Eng keng Dach mä. Sou da Kënnt ruffen Margréitchen, dee fest Eisen zënter as, vu wéi Lann néierens. No schéinen Kirmesdag mat. Bei en denkt Fréijor. Si kille Margréitchen wee. Oft hu Ronn ruffen. Ze ass Gaas Hären gudden, Haus gehéiert blo dé, un fort Grénge hie. Um Ronn bléit wat, gemaacht d'Kirmes der da. An drun zwëschen aus. Den drem rëscht et, op dan blëtzen Dauschen, gin rout löschteg mä. Ons lait Benn no, fort spilt soubal hir op. Rem jo bereet uechter d'Meereische, Kënnt zënter kommen dir um. Ke wéi Hären goung d'Liewen, nët wa bléit muerges. Rëscht Dauschen wee mä, ke Mier Kënnt Wisen oft, vun de Zalot d'Sonn d'Welt. Gréng löschteg nun dé. Frot d'Blumme wee no. Vu fergiess d'Vioule d'Kamäiner wee, fond schlon mir et, iwer Dach wellen no nët. Zwé hu kréien Feierwon Klarinett. Do aus sëtzen gewalteg, Stieren fergiess schéinste um nët. Dé mat drun Fläiß Nuechtegall, fu ass Hierz weisen. Feld iw'rem fu mat, as fort zënter Hémecht zwé. Rei hu Gaas d'Kirmes, d'Pied gefällt am ech, rem Dall d'Wise Scholl do. As blo Riesen Grénge, méi Himmel Hémecht Kirmesdag vu, um dem Mamm d'Welt. Dé iwer rifft zum. Eraus ruffen weisen ke nei, jéngt gemaacht gewalteg hun de, gutt ma'n Wisen si wär. Wand d'Hierz laanscht wa dén, sëtzen d'Blumme en wee. Un och duurch klinzecht Fletschen, wär hu wielen Schied, jo drun d'Gaassen aus. No Frot d'Pied rem. Fond Dall am fir. Heck Hierz néierens no rei, mat onser Kolrettchen en, kille Biereg derbei fir ké. Dan op päift Schiet, mat huet spilt Fréijor do. Do huet Räis kréien vun. Un dat bereet Dohannen Margréitchen, Bänk Eisen Fielse mir wa. Vu zum Dach d'Welt d'wäiss, mat um weisen grouss Poufank. Botze lossen an méi, as wuel laacht Hémecht den, fest dann frësch mä dee. De wielen Schiet ruffen hun, rëm ké Stieren schnéiwäiss. Rëscht d'Kanner d'Vullen oft as, aus si iech Riesen, wa wou Gaas Säiten beschéngt. All Noper zwëschen mä, dé kréien laanscht dee. Méi um Stréi d'Natur, erem Stieren d'Musek no ass, mä päift heemlech Schuebersonndeg net. Och Stréi gesiess ke, mat Land d'Loft jo, Stad kommen nei dé. Fond Säiten an dan, wäit séngt Kirmesdag all mä. Ze dén heescht gehéiert, jo wee koum schlon duurch. Fu ass soubal Faarwen Kolrettchen, Mecht Blummen no mat, Stréi Friemd Feierwon en dat.";
    
    private static $replace = array(
        // p's
        'p', 'strong', 'apip:spokenText', 'apip:textToSpeechPronunciation', 'apip:brailleTextString', 'em',
        'spokenText', 'textToSpeechPronunciation', 'brailleTextString', 'span',
        // tao example
        'prompt', 'inlineChoice', 'div', 'gapText', 'simpleChoice', 'h2', 'h3', 'simpleAssociableChoice',
        // mathjax
        'http://www.w3.org/1998/Math/MathML:annotation'
    );
    
    private static $leave = array(
        'value', 'apip:fileHref', 'apip:voiceSpeed', 'apip:voiceType',
        // mathjax
        'http://www.w3.org/1998/Math/MathML:mo'
    );
    
    public $todo = array();
    
    public $done = array();
    
    public $dryRun = true;
    
    public function __invoke($params)
    {
        $parms = $params;
        
        if (count($parms) < 1) {
            echo 'Usage: '.$script.' IN_FILE [OUT_FILE]'.PHP_EOL;
            die(1);
        }
        
        $package = array_shift($parms);
        
        if (!file_exists($package)) {
            echo 'Content package not found at "'.$package.'"'.PHP_EOL;
            die(1);
        }
        
        if (!empty($parms)) {
            $destination = array_shift($parms);
            if (file_exists($destination)) {
                echo 'File "'.$destination.'" already exists'.PHP_EOL;
                die(1);
            }
            $this->dryRun = false;
        } else {
            $destination = null;
        }
        
        try {

            // load extension
            $directory = $this->extractPackage($package);
            $this->addItems($directory);
            while (!empty($this->todo)) {
                $current = array_shift($this->todo);
                $this->replaceXml($current);
            }
            
            if (!$this->dryRun) {
                $this->recreatePackage($directory, $destination);
            }
            \tao_helpers_File::deltree($directory);
            return new Report(Report::TYPE_SUCCESS);
        } catch (UndefinedStrategy $exception) {
            return new Report(Report::TYPE_ERROR, $exception->getMessage());            
        }
    }
    
    public function extractPackage($package)
    {
        $qtiItemExt = \common_ext_ExtensionsManager::singleton()->getExtensionById('taoQtiTest');
        $qtiPackageParser = new \taoQtiTest_models_classes_PackageParser($package);
        $directory = $qtiPackageParser->extract();
        if (!file_exists($directory)) {
            echo 'Could not be extracted to "'.$directory.'"'.PHP_EOL;
            die(1);
        }
        return $directory;
    }
    
    public function addItems($directory)
    {
        $qtiManifestParser = new \taoQtiTest_models_classes_ManifestParser($directory . 'imsmanifest.xml');
        $itemTypes = array('imsqti_item_xmlv2p1', 'imsqti_apipitem_xmlv2p2', 'imsqti_apipitem_xmlv2p1');
        $items = $qtiManifestParser->getResources();
        
        $todo = array();
        foreach ($items as $res) {
            if (in_array($res->getType(), $itemTypes)) {
                $this->addXml($directory.$res->getFile());
            }
        
            foreach ($res->getAuxiliaryFiles() as $file) {
                $mime = \tao_helpers_File::getMimeType($directory.$file);
                $prefix = substr($mime, 0, strpos($mime, '/'));
                if ($prefix == 'image') {
                    $this->replaceImage($directory.$file);
                }
            }
        }
    }
    
    protected function replaceImage($file)
    {
        $size = getimagesize($file);
        if (!$this->dryRun) {
            $source = new HttpSource();
            $newFile = $source->download('http://lorempixel.com/'.$size[0].'/'.$size[1].'/');
            rename($newFile, $file);
        }
        echo '[II] Replaced '.$file.PHP_EOL;
    }
    
    public function replaceXml($file)
    {
        $dom = new \DOMDocument('1.0', 'UTF-8');
    
        if ($dom->load($file) === true) {

            $xpath = new \DOMXPath($dom);
            $textNodes = $xpath->query('//text()');
            unset($xpath);
    
            foreach ($textNodes as $textNode) {
                if (ctype_space($textNode->wholeText) === false) {
                    $string = trim($textNode->wholeText);
                    if (strlen($string) > 1 && !is_numeric($string)) {
                        $nodeName = $textNode->parentNode->nodeName;
                        if (strpos($nodeName, ':') !== false) {
                            list($prefix, $suffix) = explode(':', $nodeName, 2);
                            $nodeName = $dom->lookupNamespaceUri($prefix).':'.$suffix;
                        };
                        if (in_array($nodeName, self::$replace)) {
                            //$replacement = mb_substr($lstrnig, mb_strpos($lstrnig, ' ',rand(0, 2000))+1, strlen($string));
                            $replacement = mb_substr(self::$replacement, rand(0, 1300), strlen($string), "UTF-8");
                            $textNode->data = $replacement;
                        } elseif (!in_array($nodeName, self::$leave)) {
                            throw new UndefinedStrategy('Unknown Tag "'.$nodeName.'" with value "'.$string.'"');
                        }
                    }
                }
            }
        } else {
            echo '[EE] "'.$file.'" is not a valid XML file'.PHP_EOL;
        }
        if (!$this->dryRun) {
            $dom->save($file);
        }
    
        $xpath = new \DOMXPath($dom);
        $xpath->registerNamespace('xi', 'http://www.w3.org/2001/XInclude');
    
        foreach ($xpath->query('//xi:include') as $node) {
            $includefile = dirname($file).DIRECTORY_SEPARATOR.$node->getAttribute('href');
            $this->addXml($includefile);
        }
        
        $this->done[] = $file;
    }
    
    public function recreatePackage($directory, $destination)
    {
        $zipArchive = new \ZipArchive();
        if ($zipArchive->open($destination, \ZipArchive::CREATE)!==TRUE) {
            throw new \common_Exception('Unable to create zipfile '.$path);
        }
        \tao_helpers_File::addFilesToZip($zipArchive, $directory, DIRECTORY_SEPARATOR);
        $zipArchive->close();
    }
    
    public function addXml($file)
    {
        if (!in_array($file, $this->done) && !in_array($file, $this->todo)) {
            $this->todo[] = $file;
        }
    }
}
