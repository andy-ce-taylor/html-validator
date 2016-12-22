<?php

##
define('Tag_DOCTYPE',             0);
define('Tag_COMMENT',             1);
define('Tag_A',                   2);
define('Tag_ABBR',                3);
define('Tag_ACRONYM',             4);
define('Tag_ADDRESS',             5);
define('Tag_APPLET',              6);
define('Tag_AREA',                7);
define('Tag_ARTICLE',             8);
define('Tag_ASIDE',               9);
define('Tag_AUDIO',              10);
define('Tag_B',                  11);
define('Tag_BASE',               12);
define('Tag_BASEFONT',           13);
define('Tag_BDO',                14);
define('Tag_BIG',                15);
define('Tag_BLOCKQUOTE',         16);
define('Tag_BODY',               17);
define('Tag_BR',                 18);
define('Tag_BUTTON',             19);
define('Tag_CANVAS',             20);
define('Tag_CAPTION',            21);
define('Tag_CENTER',             22);
define('Tag_CITE',               23);
define('Tag_CODE',               24);
define('Tag_COL',                25);
define('Tag_COLGROUP',           26);
define('Tag_COMMAND',            27);
define('Tag_DATAGRID',           28);
define('Tag_DATALIST',           29);
define('Tag_DD',                 30);
define('Tag_DEL',                31);
define('Tag_DETAILS',            32);
define('Tag_DFN',                33);
define('Tag_DIALOG',             34);
define('Tag_DIR',                35);
define('Tag_DIV',                36);
define('Tag_DL',                 37);
define('Tag_DT',                 38);
define('Tag_EM',                 39);
define('Tag_EMBED',              40);
define('Tag_EVENTSOURCE',        41);
define('Tag_FIELDSET',           42);
define('Tag_FIGCAPTION',         43);
define('Tag_FIGURE',             44);
define('Tag_FONT',               45);
define('Tag_FOOTER',             46);
define('Tag_FORM',               47);
define('Tag_FRAME',              48);
define('Tag_FRAMESET',           49);
define('Tag_H1',                 50);
define('Tag_H2',                 51);
define('Tag_H3',                 52);
define('Tag_H4',                 53);
define('Tag_H5',                 54);
define('Tag_H6',                 55);
define('Tag_HEAD',               56);
define('Tag_HEADER',             57);
define('Tag_HGROUP',             58);
define('Tag_HR',                 59);
define('Tag_HTML',               60);
define('Tag_I',                  61);
define('Tag_IFRAME',             62);
define('Tag_IMG',                63);
define('Tag_INPUT',              64);
define('Tag_INS',                65);
define('Tag_ISINDEX',            66);
define('Tag_KBD',                67);
define('Tag_KEYGEN',             68);
define('Tag_LABEL',              69);
define('Tag_LEGEND',             70);
define('Tag_LI',                 71);
define('Tag_LINK',               72);
define('Tag_M',                  73);
define('Tag_MAP',                74);
define('Tag_MARK',               75);
define('Tag_MENU',               76);
define('Tag_META',               77);
define('Tag_METER',              78);
define('Tag_NAV',                79);
define('Tag_NOFRAMES',           80);
define('Tag_NOSCRIPT',           81);
define('Tag_OBJECT',             82);
define('Tag_OL',                 83);
define('Tag_OPTGROUP',           84);
define('Tag_OPTION',             85);
define('Tag_OUTPUT',             86);
define('Tag_P',                  87);
define('Tag_PARAM',              88);
define('Tag_PRE',                89);
define('Tag_PROGRESS',           90);
define('Tag_Q',                  91);
define('Tag_RP',                 92);
define('Tag_RT',                 93);
define('Tag_RUBY',               94);
define('Tag_S',                  95);
define('Tag_SAMP',               96);
define('Tag_SCRIPT',             97);
define('Tag_SECTION',            98);
define('Tag_SELECT',             99);
define('Tag_SMALL',             100);
define('Tag_SOURCE',            101);
define('Tag_SPAN',              102);
define('Tag_STRIKE',            103);
define('Tag_STRONG',            104);
define('Tag_STYLE',             105);
define('Tag_SUB',               106);
define('Tag_SUMMARY',           107);
define('Tag_SUP',               108);
define('Tag_TABLE',             109);
define('Tag_TBODY',             110);
define('Tag_TD',                111);
define('Tag_TEXTAREA',          112);
define('Tag_TFOOT',             113);
define('Tag_TH',                114);
define('Tag_THEAD',             115);
define('Tag_TIME',              116);
define('Tag_TITLE',             117);
define('Tag_TR',                118);
define('Tag_TT',                119);
define('Tag_U',                 120);
define('Tag_UL',                121);
define('Tag_VAR',               122);
define('Tag_VIDEO',             123);
define('Tag_WBR',               124);
define('Tag_PAGE_ROOT',         125);  // must be the last but one in this list
define('Tag_UNKNOWN',           126);  // must be the last in this list

define('Tag_NUM_TAGS',          Tag_UNKNOWN + 1);

##
define('TagAllw_FBD',             0);  // tag is required
define('TagAllw_OPT',             1);  // tag is optional
define('TagAllw_REQ',             2);  // tag is forbidden

##
define('Stat_HTML4',             0x0001);
define('Stat_HTML5',             0x0002);
define('Stat_Unused_1',          0x0004);
define('Stat_Unused_2',          0x0008);
define('Stat_DEPRECATED',        0x0010);
define('Stat_UNKNOWN',           0x0020);
define('Stat_Unused_3',          0x0040);
define('Stat_Unused_4',          0x0080);
define('Stat_Unused_5',          0x0100);
define('Stat_Unused_6',          0x0200);

##
$scpNames = array();
define('ANY_ELEMENT',            1000);  $scpNames[ANY_ELEMENT]  = 'any';
define('BLOCK',                  1001);  $scpNames[BLOCK]        = 'block';
define('INLINE',                 1002);  $scpNames[INLINE]       = 'inline';
define('TEXT',                   1003);  $scpNames[TEXT]         = 'text';

##
$ScpLut = array();
define('Scp_ANY',                 0);    $ScpLut[Scp_ANY] =                array(ANY_ELEMENT);
define('Scp_ARTICLE',             1);    $ScpLut[Scp_ARTICLE] =            array(Tag_ARTICLE);
define('Scp_AV',                  2);    $ScpLut[Scp_AV] =                 array(Tag_AUDIO, Tag_VIDEO);
define('Scp_BLOCK',               3);    $ScpLut[Scp_BLOCK] =              array(BLOCK);
define('Scp_BLOCK_AREA',          4);    $ScpLut[Scp_BLOCK_AREA] =         array(BLOCK, Tag_AREA);
define('Scp_BLOCK_INLINE',        5);    $ScpLut[Scp_BLOCK_INLINE] =       array(BLOCK, INLINE);
define('Scp_BLOCK_INLINE_TEXT',   6);    $ScpLut[Scp_BLOCK_INLINE_TEXT] =  array(BLOCK, INLINE, TEXT);
define('Scp_BLOCK_SCRIPT',        7);    $ScpLut[Scp_BLOCK_SCRIPT] =       array(Tag_SCRIPT, BLOCK);
define('Scp_BODY_B_I_T',          8);    $ScpLut[Scp_BODY_B_I_T] =         array(Tag_BODY, BLOCK, INLINE, TEXT);
define('Scp_CG_TABLE',            9);    $ScpLut[Scp_CG_TABLE] =           array(Tag_COLGROUP, Tag_TABLE);
define('Scp_COL',                10);    $ScpLut[Scp_COL] =                array(Tag_COL);
define('Scp_COMMAND',            11);    $ScpLut[Scp_COMMAND] =            array(Tag_COMMAND);
define('Scp_C_C_CG_TH_TF_TB',    12);    $ScpLut[Scp_C_C_CG_TH_TF_TB] =    array(Tag_CAPTION, Tag_COL, Tag_COLGROUP, Tag_THEAD, Tag_TFOOT, Tag_TBODY, Tag_TR);
define('Scp_DD_DT',              13);    $ScpLut[Scp_DD_DT] =              array(Tag_DD, Tag_DT);
define('Scp_DETAILS',            14);    $ScpLut[Scp_DETAILS] =            array(Tag_DETAILS);
define('Scp_DL',                 15);    $ScpLut[Scp_DL] =                 array(Tag_DL);
define('Scp_EMPTY',              16);    $ScpLut[Scp_EMPTY] =              array();
define('Scp_FIGURE',             17);    $ScpLut[Scp_FIGURE] =             array(Tag_FIGURE);
define('Scp_FRAMESET',           18);    $ScpLut[Scp_FRAMESET] =           array(Tag_FRAMESET);
define('Scp_FS_DET',             19);    $ScpLut[Scp_FS_DET] =             array(Tag_FIELDSET, Tag_DETAILS);
define('Scp_FS_F_NF',            20);    $ScpLut[Scp_FS_F_NF] =            array(Tag_FRAMESET, Tag_FRAME, Tag_NOFRAMES);
define('Scp_H1_H2_H3_H4_H5_H6',  21);    $ScpLut[Scp_H1_H2_H3_H4_H5_H6] =  array(Tag_H1, Tag_H2, Tag_H3, Tag_H4, Tag_H5, Tag_H6);
define('Scp_HEAD',               22);    $ScpLut[Scp_HEAD] =               array(Tag_HEAD);
define('Scp_HTML',               23);    $ScpLut[Scp_HTML] =               array(Tag_HTML);
define('Scp_HTML_NF',            24);    $ScpLut[Scp_HTML_NF] =            array(Tag_HTML, Tag_NOFRAMES);
define('Scp_H_B_FS',             25);    $ScpLut[Scp_H_B_FS] =             array(Tag_HEAD, Tag_BODY, Tag_FRAMESET);
define('Scp_INLINE',             26);    $ScpLut[Scp_INLINE] =             array(INLINE);
define('Scp_INLINE_HEAD',        27);    $ScpLut[Scp_INLINE_HEAD] =        array(INLINE, Tag_HEAD);
define('Scp_INLINE_TEXT',        28);    $ScpLut[Scp_INLINE_TEXT] =        array(INLINE, TEXT);
define('Scp_INPUT',              29);    $ScpLut[Scp_INPUT] =              array(Tag_INPUT);
define('Scp_LI',                 30);    $ScpLut[Scp_LI] =                 array(Tag_LI);
define('Scp_L_B_I_T',            31);    $ScpLut[Scp_L_B_I_T] =            array(Tag_LEGEND, BLOCK, INLINE, TEXT);
define('Scp_MAP',                32);    $ScpLut[Scp_MAP] =                array(Tag_MAP);
define('Scp_MENU',               33);    $ScpLut[Scp_MENU] =               array(Tag_MENU);
define('Scp_NULL',               34);    $ScpLut[Scp_NULL] =               array();
define('Scp_OBJ_APPLET',         35);    $ScpLut[Scp_OBJ_APPLET] =         array(Tag_OBJECT, Tag_APPLET);
define('Scp_OG_OPT',             36);    $ScpLut[Scp_OG_OPT] =             array(Tag_OPTGROUP, Tag_OPTION);
define('Scp_OPTION',             37);    $ScpLut[Scp_OPTION] =             array(Tag_OPTION);
define('Scp_P_INLINE_TEXT',      38);    $ScpLut[Scp_P_INLINE_TEXT] =      array(Tag_P, INLINE, TEXT);
define('Scp_PAGE_ROOT',          39);    $ScpLut[Scp_PAGE_ROOT] =          array(Tag_DOCTYPE, Tag_HTML);
define('Scp_RP_RT',              40);    $ScpLut[Scp_RP_RT] =              array(Tag_RP, Tag_RT);
define('Scp_RUBY',               41);    $ScpLut[Scp_RUBY] =               array(Tag_RUBY);
define('Scp_SELECT',             42);    $ScpLut[Scp_SELECT] =             array(Tag_SELECT);
define('Scp_SEL_OPTG',           43);    $ScpLut[Scp_SEL_OPTG] =           array(Tag_SELECT, Tag_OPTGROUP);
define('Scp_TABLE',              44);    $ScpLut[Scp_TABLE] =              array(Tag_TABLE);
define('Scp_TEXT',               45);    $ScpLut[Scp_TEXT] =               array(TEXT);
define('Scp_TH_TD',              46);    $ScpLut[Scp_TH_TD] =              array(Tag_TH, Tag_TD);
define('Scp_TH_TF_TB',           47);    $ScpLut[Scp_TH_TF_TB] =           array(Tag_THEAD, Tag_TFOOT, Tag_TBODY);
define('Scp_TR',                 48);    $ScpLut[Scp_TR] =                 array(Tag_TR);
define('Scp_T_I_B_S_S_M_L_O',    49);    $ScpLut[Scp_T_I_B_S_S_M_L_O] =    array(Tag_TITLE, Tag_ISINDEX, Tag_BASE, Tag_SCRIPT, Tag_STYLE, Tag_META, Tag_LINK, Tag_OBJECT);
define('Scp_UL_OL_D_M',          50);    $ScpLut[Scp_UL_OL_D_M] =          array(Tag_UL, Tag_OL, Tag_DIR, Tag_MENU);

##
define('HtmlDatIx_NAME',                0);
define('HtmlDatIx_REQ_START_TAG',       1);
define('HtmlDatIx_REQ_END_TAG',         2);
define('HtmlDatIx_REQ_DISPLAY',         3);
define('HtmlDatIx_REQ_CONTENT',         4);
define('HtmlDatIx_STATUS',              5);
define('HtmlDatIx_EXP_REQ_CONTENT',     6);  // expanded content elements allowed

$htmlDat = array(  //
  //    name              start tag     end tag       display            content                     html status
  array('!doctype',       TagAllw_REQ,  TagAllw_FBD,  Scp_NULL,          Scp_NULL,                   Stat_HTML4),
  array('!--',            TagAllw_REQ,  TagAllw_FBD,  Scp_NULL,          Scp_NULL,                   Stat_HTML4),
  array('a',              TagAllw_REQ,  TagAllw_REQ,  Scp_INLINE,        Scp_INLINE_TEXT,            Stat_HTML4),
  array('abbr',           TagAllw_REQ,  TagAllw_REQ,  Scp_INLINE,        Scp_INLINE_TEXT,            Stat_HTML4),
  array('acronym',        TagAllw_REQ,  TagAllw_REQ,  Scp_INLINE,        Scp_INLINE_TEXT,            Stat_HTML4),
  array('address',        TagAllw_REQ,  TagAllw_REQ,  Scp_BLOCK,         Scp_P_INLINE_TEXT,          Stat_HTML4),
  array('applet',         TagAllw_REQ,  TagAllw_REQ,  Scp_BLOCK,         Scp_BLOCK_INLINE_TEXT,      Stat_DEPRECATED),
  array('area',           TagAllw_REQ,  TagAllw_FBD,  Scp_NULL,          Scp_EMPTY,                  Stat_HTML4),
  array('article',        TagAllw_REQ,  TagAllw_REQ,  Scp_BLOCK,         Scp_BLOCK_INLINE_TEXT,      Stat_HTML5),/////////////
  array('aside',          TagAllw_REQ,  TagAllw_REQ,  Scp_BLOCK,         Scp_BLOCK_INLINE_TEXT,      Stat_HTML5),/////////////
  array('audio',          TagAllw_REQ,  TagAllw_REQ,  Scp_BLOCK,         Scp_BLOCK_INLINE_TEXT,      Stat_HTML5),/////////////
  array('b',              TagAllw_REQ,  TagAllw_REQ,  Scp_INLINE,        Scp_INLINE_TEXT,            Stat_HTML4),
  array('base',           TagAllw_REQ,  TagAllw_FBD,  Scp_NULL,          Scp_EMPTY,                  Stat_HTML4),
  array('basefont',       TagAllw_REQ,  TagAllw_FBD,  Scp_NULL,          Scp_EMPTY,                  Stat_DEPRECATED),
  array('bdo',            TagAllw_REQ,  TagAllw_REQ,  Scp_INLINE,        Scp_INLINE_TEXT,            Stat_HTML4),
  array('big',            TagAllw_REQ,  TagAllw_REQ,  Scp_INLINE,        Scp_INLINE_TEXT,            Stat_HTML4),
  array('blockquote',     TagAllw_REQ,  TagAllw_REQ,  Scp_BLOCK,         Scp_BLOCK_INLINE_TEXT,      Stat_HTML4),
  array('body',           TagAllw_OPT,  TagAllw_REQ,  Scp_BLOCK,         Scp_BLOCK_INLINE_TEXT,      Stat_HTML4),
  array('br',             TagAllw_REQ,  TagAllw_FBD,  Scp_NULL,          Scp_EMPTY,                  Stat_HTML4),
  array('button',         TagAllw_REQ,  TagAllw_REQ,  Scp_INLINE,        Scp_BLOCK_INLINE_TEXT,      Stat_HTML4),
  array('canvas',         TagAllw_REQ,  TagAllw_REQ,  Scp_BLOCK,         Scp_BLOCK_INLINE_TEXT,      Stat_HTML5),/////////////
  array('caption',        TagAllw_REQ,  TagAllw_REQ,  Scp_INLINE,        Scp_INLINE_TEXT,            Stat_HTML4),
  array('center',         TagAllw_REQ,  TagAllw_REQ,  Scp_BLOCK,         Scp_BLOCK_INLINE_TEXT,      Stat_DEPRECATED),
  array('cite',           TagAllw_REQ,  TagAllw_REQ,  Scp_INLINE,        Scp_INLINE_TEXT,            Stat_HTML4),
  array('code',           TagAllw_REQ,  TagAllw_REQ,  Scp_INLINE,        Scp_INLINE_TEXT,            Stat_HTML4),
  array('col',            TagAllw_REQ,  TagAllw_FBD,  Scp_NULL,          Scp_EMPTY,                  Stat_HTML4),
  array('colgroup',       TagAllw_REQ,  TagAllw_OPT,  Scp_NULL,          Scp_COL,                    Stat_HTML4),
  array('command',        TagAllw_REQ,  TagAllw_FBD,  Scp_INLINE,        Scp_EMPTY,                  Stat_HTML5),////////////
  array('datagrid',       TagAllw_REQ,  TagAllw_REQ,  Scp_BLOCK,         Scp_BLOCK,                  Stat_HTML5),////////////
  array('datalist',       TagAllw_REQ,  TagAllw_REQ,  Scp_INLINE,        Scp_OPTION,                 Stat_HTML5),////////////
  array('dd',             TagAllw_REQ,  TagAllw_OPT,  Scp_BLOCK,         Scp_BLOCK_INLINE_TEXT,      Stat_HTML4),
  array('del',            TagAllw_REQ,  TagAllw_REQ,  Scp_BLOCK_INLINE,  Scp_BLOCK_INLINE_TEXT,      Stat_HTML4),
  array('details',        TagAllw_REQ,  TagAllw_REQ,  Scp_INLINE,        Scp_INLINE_TEXT,            Stat_HTML4),
  array('dfn',            TagAllw_REQ,  TagAllw_REQ,  Scp_INLINE,        Scp_INLINE_TEXT,            Stat_HTML4),
  array('dialog',         TagAllw_REQ,  TagAllw_REQ,  Scp_BLOCK,         Scp_BLOCK_INLINE_TEXT,      Stat_HTML5),////////////
  array('dir',            TagAllw_REQ,  TagAllw_REQ,  Scp_BLOCK,         Scp_LI,                     Stat_DEPRECATED),
  array('div',            TagAllw_REQ,  TagAllw_REQ,  Scp_BLOCK,         Scp_BLOCK_INLINE_TEXT,      Stat_HTML4),
  array('dl',             TagAllw_REQ,  TagAllw_REQ,  Scp_BLOCK,         Scp_DD_DT,                  Stat_HTML4),
  array('dt',             TagAllw_REQ,  TagAllw_OPT,  Scp_BLOCK,         Scp_INLINE_TEXT,            Stat_HTML4),
  array('em',             TagAllw_REQ,  TagAllw_REQ,  Scp_INLINE,        Scp_INLINE_TEXT,            Stat_HTML4),
  array('embed',          TagAllw_REQ,  TagAllw_FBD,  Scp_BLOCK,         Scp_EMPTY,                  Stat_HTML5),/////////////
  array('eventsource',    TagAllw_REQ,  TagAllw_FBD,  Scp_INLINE,        Scp_EMPTY,                  Stat_HTML5),////////////
  array('fieldset',       TagAllw_REQ,  TagAllw_REQ,  Scp_BLOCK,         Scp_L_B_I_T,                Stat_HTML4),
  array('figcaption',     TagAllw_REQ,  TagAllw_REQ,  Scp_INLINE,        Scp_INLINE_TEXT,            Stat_HTML5),/////////////
  array('figure',         TagAllw_REQ,  TagAllw_REQ,  Scp_BLOCK,         Scp_INLINE_TEXT,            Stat_HTML5),/////////////
  //
  //    name              start tag     end tag       display            content                     html status
  array('font',           TagAllw_REQ,  TagAllw_REQ,  Scp_INLINE,        Scp_INLINE_TEXT,            Stat_DEPRECATED),
  array('footer',         TagAllw_REQ,  TagAllw_REQ,  Scp_BLOCK,         Scp_BLOCK_INLINE_TEXT,      Stat_HTML5),/////////////
  array('form',           TagAllw_REQ,  TagAllw_REQ,  Scp_BLOCK,         Scp_BLOCK_INLINE_TEXT,      Stat_HTML4),        // if strict, content = Scp_BLOCK_SCRIPT
  array('frame',          TagAllw_REQ,  TagAllw_FBD,  Scp_BLOCK,         Scp_EMPTY,                  Stat_HTML4),
  array('frameset',       TagAllw_REQ,  TagAllw_REQ,  Scp_BLOCK,         Scp_FS_F_NF,                Stat_HTML4),
  array('h1',             TagAllw_REQ,  TagAllw_REQ,  Scp_BLOCK,         Scp_INLINE_TEXT,            Stat_HTML4),
  array('h2',             TagAllw_REQ,  TagAllw_REQ,  Scp_BLOCK,         Scp_INLINE_TEXT,            Stat_HTML4),
  array('h3',             TagAllw_REQ,  TagAllw_REQ,  Scp_BLOCK,         Scp_INLINE_TEXT,            Stat_HTML4),
  array('h4',             TagAllw_REQ,  TagAllw_REQ,  Scp_BLOCK,         Scp_INLINE_TEXT,            Stat_HTML4),
  array('h5',             TagAllw_REQ,  TagAllw_REQ,  Scp_BLOCK,         Scp_INLINE_TEXT,            Stat_HTML4),
  array('h6',             TagAllw_REQ,  TagAllw_REQ,  Scp_BLOCK,         Scp_INLINE_TEXT,            Stat_HTML4),
  array('head',           TagAllw_OPT,  TagAllw_REQ,  Scp_NULL,          Scp_T_I_B_S_S_M_L_O,        Stat_HTML4),
  array('header',         TagAllw_REQ,  TagAllw_REQ,  Scp_BLOCK,         Scp_BLOCK_INLINE_TEXT,      Stat_HTML5),/////////////
  array('hgroup',         TagAllw_REQ,  TagAllw_REQ,  Scp_BLOCK,         Scp_H1_H2_H3_H4_H5_H6,      Stat_HTML5),/////////////
  array('hr',             TagAllw_REQ,  TagAllw_FBD,  Scp_NULL,          Scp_EMPTY,                  Stat_HTML4),
  array('html',           TagAllw_OPT,  TagAllw_REQ,  Scp_NULL,          Scp_H_B_FS,                 Stat_HTML4),
  array('i',              TagAllw_REQ,  TagAllw_REQ,  Scp_INLINE,        Scp_INLINE_TEXT,            Stat_HTML4),
  array('iframe',         TagAllw_REQ,  TagAllw_REQ,  Scp_BLOCK,         Scp_BLOCK_INLINE_TEXT,      Stat_HTML4),
  array('img',            TagAllw_REQ,  TagAllw_FBD,  Scp_INLINE,        Scp_EMPTY,                  Stat_HTML4),
  array('input',          TagAllw_REQ,  TagAllw_FBD,  Scp_INLINE,        Scp_EMPTY,                  Stat_HTML4),
  array('ins',            TagAllw_REQ,  TagAllw_REQ,  Scp_BLOCK_INLINE,  Scp_BLOCK_INLINE_TEXT,      Stat_HTML4),
  array('isindex',        TagAllw_REQ,  TagAllw_FBD,  Scp_INLINE,        Scp_EMPTY,                  Stat_DEPRECATED),
  array('kbd',            TagAllw_REQ,  TagAllw_REQ,  Scp_INLINE,        Scp_INLINE_TEXT,            Stat_HTML4),
  array('keygen',         TagAllw_REQ,  TagAllw_FBD,  Scp_NULL,          Scp_EMPTY,                  Stat_HTML5),//////
  array('label',          TagAllw_REQ,  TagAllw_REQ,  Scp_INLINE,        Scp_INLINE_TEXT,            Stat_HTML4),
  array('legend',         TagAllw_REQ,  TagAllw_REQ,  Scp_INLINE,        Scp_INLINE_TEXT,            Stat_HTML4),
  array('li',             TagAllw_REQ,  TagAllw_OPT,  Scp_BLOCK,         Scp_BLOCK_INLINE_TEXT,      Stat_HTML4),
  array('link',           TagAllw_REQ,  TagAllw_FBD,  Scp_NULL,          Scp_EMPTY,                  Stat_HTML4),
  array('m',              TagAllw_REQ,  TagAllw_REQ,  Scp_INLINE,        Scp_INLINE_TEXT,            Stat_HTML5),/////////////
  array('map',            TagAllw_REQ,  TagAllw_REQ,  Scp_INLINE,        Scp_BLOCK_AREA,             Stat_HTML4),
  array('mark',           TagAllw_REQ,  TagAllw_REQ,  Scp_INLINE,        Scp_INLINE_TEXT,            Stat_HTML5),/////////////
  array('menu',           TagAllw_REQ,  TagAllw_REQ,  Scp_BLOCK,         Scp_COMMAND,                Stat_HTML5),/////////////
  array('meta',           TagAllw_REQ,  TagAllw_FBD,  Scp_NULL,          Scp_EMPTY,                  Stat_HTML4),
  array('meter',          TagAllw_REQ,  TagAllw_REQ,  Scp_INLINE,        Scp_INLINE_TEXT,            Stat_HTML5),/////////////
  array('nav',            TagAllw_REQ,  TagAllw_REQ,  Scp_BLOCK,         Scp_BLOCK_INLINE_TEXT,      Stat_HTML5),/////////////
  array('noframes',       TagAllw_REQ,  TagAllw_REQ,  Scp_BLOCK,         Scp_BODY_B_I_T,             Stat_HTML4),
  array('noscript',       TagAllw_REQ,  TagAllw_REQ,  Scp_BLOCK,         Scp_BLOCK_INLINE_TEXT,      Stat_HTML4),
  array('object',         TagAllw_REQ,  TagAllw_REQ,  Scp_BLOCK,         Scp_BLOCK_INLINE_TEXT,      Stat_HTML4),
  array('ol',             TagAllw_REQ,  TagAllw_REQ,  Scp_BLOCK,         Scp_LI,                     Stat_HTML4),
  array('optgroup',       TagAllw_REQ,  TagAllw_REQ,  Scp_NULL,          Scp_OPTION,                 Stat_HTML4),
  array('option',         TagAllw_REQ,  TagAllw_OPT,  Scp_INLINE,        Scp_TEXT,                   Stat_HTML4),
  array('output',         TagAllw_REQ,  TagAllw_REQ,  Scp_INLINE,        Scp_INLINE_TEXT,            Stat_HTML5),/////////////
  array('p',              TagAllw_REQ,  TagAllw_OPT,  Scp_BLOCK,         Scp_INLINE_TEXT,            Stat_HTML4),
  array('param',          TagAllw_REQ,  TagAllw_FBD,  Scp_NULL,          Scp_EMPTY,                  Stat_HTML4),
  array('pre',            TagAllw_REQ,  TagAllw_REQ,  Scp_BLOCK,         Scp_INLINE_TEXT,            Stat_HTML4),
  //
  //    name              start tag      end tag        display            content                      html status
  array('progress',       TagAllw_REQ,  TagAllw_REQ,  Scp_INLINE,        Scp_INLINE_TEXT,            Stat_HTML5),/////////////
  array('q',              TagAllw_REQ,  TagAllw_REQ,  Scp_INLINE,        Scp_INLINE_TEXT,            Stat_HTML4),
  array('rp',             TagAllw_REQ,  TagAllw_REQ,  Scp_INLINE,        Scp_INLINE_TEXT,            Stat_HTML5),/////////
  array('rt',             TagAllw_REQ,  TagAllw_REQ,  Scp_INLINE,        Scp_INLINE_TEXT,            Stat_HTML5),/////////
  array('ruby',           TagAllw_REQ,  TagAllw_REQ,  Scp_BLOCK,         Scp_RP_RT,                  Stat_HTML5),/////////
  array('s',              TagAllw_REQ,  TagAllw_REQ,  Scp_INLINE,        Scp_INLINE_TEXT,            Stat_DEPRECATED),
  array('samp',           TagAllw_REQ,  TagAllw_REQ,  Scp_INLINE,        Scp_INLINE_TEXT,            Stat_HTML4),
  array('script',         TagAllw_REQ,  TagAllw_REQ,  Scp_NULL,          Scp_TEXT,                   Stat_HTML4),
  array('section',        TagAllw_REQ,  TagAllw_FBD,  Scp_INLINE,        Scp_TEXT,                   Stat_HTML5),/////////////
  array('select',         TagAllw_REQ,  TagAllw_REQ,  Scp_INLINE,        Scp_OG_OPT,                 Stat_HTML4),
  array('small',          TagAllw_REQ,  TagAllw_REQ,  Scp_INLINE,        Scp_INLINE_TEXT,            Stat_HTML4),
  array('source',         TagAllw_REQ,  TagAllw_FBD,  Scp_INLINE,        Scp_TEXT,                   Stat_HTML5),//////////
  array('span',           TagAllw_REQ,  TagAllw_REQ,  Scp_INLINE,        Scp_INLINE_TEXT,            Stat_HTML4),
  array('strike',         TagAllw_REQ,  TagAllw_REQ,  Scp_INLINE,        Scp_INLINE_TEXT,            Stat_DEPRECATED),
  array('strong',         TagAllw_REQ,  TagAllw_REQ,  Scp_INLINE,        Scp_INLINE_TEXT,            Stat_HTML4),
  array('style',          TagAllw_REQ,  TagAllw_REQ,  Scp_NULL,          Scp_TEXT,                   Stat_HTML4),
  array('sub',            TagAllw_REQ,  TagAllw_REQ,  Scp_INLINE,        Scp_INLINE_TEXT,            Stat_HTML4),
  array('summary',        TagAllw_REQ,  TagAllw_REQ,  Scp_INLINE,        Scp_INLINE_TEXT,            Stat_HTML5),//////////////
  array('sup',            TagAllw_REQ,  TagAllw_REQ,  Scp_INLINE,        Scp_INLINE_TEXT,            Stat_HTML4),
  array('table',          TagAllw_REQ,  TagAllw_REQ,  Scp_BLOCK,         Scp_C_C_CG_TH_TF_TB,        Stat_HTML4),
  array('tbody',          TagAllw_REQ,  TagAllw_OPT,  Scp_NULL,          Scp_TR,                     Stat_HTML4),
  array('td',             TagAllw_REQ,  TagAllw_OPT,  Scp_NULL,          Scp_BLOCK_INLINE_TEXT,      Stat_HTML4),
  array('textarea',       TagAllw_REQ,  TagAllw_REQ,  Scp_INLINE,        Scp_TEXT,                   Stat_HTML4),
  array('tfoot',          TagAllw_REQ,  TagAllw_OPT,  Scp_NULL,          Scp_TR,                     Stat_HTML4),
  array('th',             TagAllw_REQ,  TagAllw_OPT,  Scp_NULL,          Scp_BLOCK_INLINE_TEXT,      Stat_HTML4),
  array('thead',          TagAllw_REQ,  TagAllw_OPT,  Scp_NULL,          Scp_TR,                     Stat_HTML4),
  array('time',           TagAllw_REQ,  TagAllw_REQ,  Scp_INLINE,        Scp_INLINE_TEXT,            Stat_HTML5),/////////////
  array('title',          TagAllw_REQ,  TagAllw_REQ,  Scp_NULL,          Scp_TEXT,                   Stat_HTML4),
  array('tr',             TagAllw_REQ,  TagAllw_OPT,  Scp_NULL,          Scp_TH_TD,                  Stat_HTML4),
  array('tt',             TagAllw_REQ,  TagAllw_REQ,  Scp_INLINE,        Scp_INLINE_TEXT,            Stat_HTML4),
  array('u',              TagAllw_REQ,  TagAllw_REQ,  Scp_INLINE,        Scp_INLINE_TEXT,            Stat_DEPRECATED),
  array('ul',             TagAllw_REQ,  TagAllw_REQ,  Scp_BLOCK,         Scp_LI,                     Stat_HTML4),
  array('var',            TagAllw_REQ,  TagAllw_REQ,  Scp_INLINE,        Scp_INLINE_TEXT,            Stat_HTML4),
  array('video',          TagAllw_REQ,  TagAllw_REQ,  Scp_BLOCK,         Scp_BLOCK_INLINE_TEXT,      Stat_HTML5),/////////////
  array('wbr',            TagAllw_REQ,  TagAllw_FBD,  Scp_NULL,          Scp_EMPTY,                  Stat_HTML4),
  //
  //    name              start tag     end tag       display            content                     html status
  array('page root',      TagAllw_REQ,  TagAllw_FBD,  Scp_NULL,          Scp_PAGE_ROOT,              Stat_HTML4),// Universal page root pseudo-tag
  array('unknown tag',    TagAllw_REQ,  TagAllw_OPT,  Scp_NULL,          Scp_ANY,                    Stat_HTML4)
);


$numHtmlTags = Tag_NUM_TAGS;

## find all block and inline elements
$anyElement = array();
$allBlockElements = array();
$allInlineElements = array();
for ($i = 1; $i < $numHtmlTags; $i++) {
  $displayType = $htmlDat[$i][HtmlDatIx_REQ_DISPLAY];
  $anyElement[] = $i;
  if ($displayType == Scp_BLOCK || $displayType == Scp_BLOCK_INLINE || $displayType == Scp_NULL) {
    $allBlockElements[] = $i;
  }
  if ($displayType == Scp_INLINE || $displayType == Scp_BLOCK_INLINE || $displayType == Scp_NULL) {
    $allInlineElements[] = $i;
  }
}

##
function getTagName($tag, $addBrackets=false, $close=false) {
  global $htmlDat;
  $name = ($close ? '/' : '').$htmlDat[$tag][HtmlDatIx_NAME];
  if ($addBrackets) {
    return "&lt;{$name}&gt;";
  }
  return $name;
}

##
function findTagName($name) {
  global $htmlTagNames;
  return array_search(strtolower($name), $htmlTagNames);
}

##
function getAllowedContentStr($tag) {
  global $scpNames, $htmlDat, $numHtmlTags;
  $html = $htmlDat[$tag];
  $str = "Element '".getTagName($tag, true)."' ";
//showText(getTagName($tag, true));
  $reqCont = $html[HtmlDatIx_REQ_CONTENT];
  if (($numElems = count($reqCont)) == 0) {
    return $str. "does not allow any child elements";
  }
  $ar = array();
  foreach ($reqCont as $rc) {
    if ($rc < $numHtmlTags) {
      $ar[] = getTagName($rc, true);
    }
    else {
      $ar[] = $scpNames[$rc];
    }
  }
  if ($numElems == 1) {
    return $str."only allows ".$ar[0]." elements";
  }
  $str .= "allows only ";
  $numElems--;
  for ($ix = 0; $ix < $numElems; $ix++) {
    if ($ix) $str .= ", ";
    $str .= $ar[$ix];
  }
  $str .= " and ".$ar[$ix]." elements";
  return $str;
}

##
function expandAllowedTags($tagIx, $datIx) {
  global $ScpLut, $htmlDat, $anyElement, $allBlockElements, $allInlineElements;
  $ar = array();
  $allowed = $ScpLut[$htmlDat[$tagIx][$datIx]];
  foreach ($allowed as $s) {
    switch ($s) {
      case ANY_ELEMENT:
        $ar = array_merge($ar, $anyElement);
        $ar[] = TEXT;
        break;

      case BLOCK:
        $ar = array_merge($ar, $allBlockElements);
        break;

      case INLINE:
        $ar = array_merge($ar, $allInlineElements);
        break;

      case TEXT:
      default:
        $ar[] = $s;
        break;
    }
  }
  return array_unique($ar);
}

##
## Find for $srchTag within the allowed contents list for $tag.
## If found, return the index, otherwise return false.
function getEndTagReq($tag) {
  global $htmlDat;
  return $htmlDat[$tag][HtmlDatIx_REQ_END_TAG];
}

##
## Find for $srchTag within the allowed contents list for $tag.
## If found, return the index, otherwise return false.
function elementAllowedInContent($srchTag, $tag) {
  global $htmlDat;
  $allowed  = $htmlDat[$tag][HtmlDatIx_EXP_REQ_CONTENT];
  return array_search($srchTag, $allowed);
}

##
$numHtmlTags = count($htmlDat);
$htmlTagNames = array();
for ($i = 0; $i < $numHtmlTags; $i++) {
  $htmlDat[$i][HtmlDatIx_REQ_DISPLAY]        = expandAllowedTags($i, HtmlDatIx_REQ_DISPLAY);
  $htmlDat[$i][HtmlDatIx_EXP_REQ_CONTENT]    = expandAllowedTags($i, HtmlDatIx_REQ_CONTENT);
  $htmlDat[$i][HtmlDatIx_REQ_CONTENT]    = $ScpLut[$htmlDat[$i][HtmlDatIx_REQ_CONTENT]];

  $htmlTagNames[] = strtolower($htmlDat[$i][HtmlDatIx_NAME]);
}

unset($ScpLut);



//for ($ix = 0; $ix < $numHtmlTags; $ix++) {
//  showText(getAllowedContentStr($ix));
//}
//showText();exit();

?>