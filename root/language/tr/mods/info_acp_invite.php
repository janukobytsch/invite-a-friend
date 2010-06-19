<?php
/**
*
* info_acp_invite [Turkish]
*
* @author Bycoja bycoja@web.de
* @package language
* @version $Id info_acp_invite.php 0.6.1 2010-04-05 15:14:09GMT Bycoja $
* @copyright (c) 2010 Bycoja
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
* @translator muiketi - http://www.nethikayesi.com/ - http://www.phpbbturkiye.net/memberlist.php?mode=viewprofile&u=666
*
* Turkish tranlation by:
* muiketi
*/

/**
* DO NOT CHANGE
*/
if (!defined('IN_PHPBB'))
{
	exit;
}

if (empty($lang) || !is_array($lang))
{
	$lang = array();
}

// DEVELOPERS PLEASE NOTE
//
// Placeholders can now contain order information, e.g. instead of
// 'Page %s of %s' you can (and should) write 'Page %1$s of %2$s', this allows
// translators to re-order the output of data while ensuring it remains correct
//
// You do not need this where single placeholders are used, e.g. 'Message %d' is fine
// equally where a string contains only two placeholders which are used to wrap text
// in a url you again do not need to specify an order e.g., 'Click %sHERE%s' is fine

// Permissions
$lang = array_merge($lang, array(
	'acl_a_invite_settings'	=> array('lang' => 'Davetiye ayarlarını yönetebilir', 'cat' => 'misc'),
	'acl_a_invite_log'		=> array('lang' => 'Davetiye kayıtlarını yönetebilir', 'cat' => 'misc'),
    'acl_u_send_invite'		=> array('lang' => 'Davetiye gönderebilir', 'cat' => 'misc'),
));

$lang = array_merge($lang, array(
	'ACP_INVITE'						=> 'Arkadışını davet et',
	'ACP_INVITE_SETTINGS'				=> 'Davetiye ayarları',
	'ACP_INVITE_SETTINGS_EXPLAIN'		=> 'Bu panelde, davetiye gönderim ayarlarını yapabilirsiniz.',
	'ACP_INVITE_TEMPLATES'				=> 'Şablonlar',
	'ACP_INVITE_TEMPLATES_EXPLAIN'		=> 'Bu panelde, tüm davet şablonlarını değiştirebilirsiniz. You can find both the templates for the confirmation sent to the inviter and the invitation itself below. As for the invitation templates, the user´s message and subject will be embedded into the template by using wildcards in curly braces. For a full list of possible wildcards look at the table below. Please note that you must not enter HTML or BBCode but plain text.',
	'ACP_INVITE_LOG'					=> 'Davetiye kayıtları',
	'ACP_INVITE_LOG_EXPLAIN'			=> 'Davetiye sistemine ait tüm kayıtlara buradan ulaşabilirsiniz. Aşağıdaki form aracılığıyla istediğiniz belirli bir bilgiye ulaşabilirsiniz. Tüm alanları doldurmak zorunda değilsiniz.',
	'ACP_INVITE_DISPLAY_OPTIONS'		=> 'Gösterim seçenekleri',
	'ACP_INVITE_LIMITATION_OPTIONS'		=> 'Sınırlamalar',

	// Error messages
	'ERROR_EMAIL_DISABLED'				=> 'E-postalar devre dışı bırakıldığından davetiye yollayamazsınız.<br /><br /><a href="%s">» E-posta ayarlarını değiştirin</a>',
	'ERROR_INVITE_SETTINGS'				=> 'Tüm alanları doğru bir şekilde doldurmalısınız.',
	'ERROR_MESSAGE_INVITE'				=> 'Tüm davetiye alanlarını doldurmalısınız. Lütfen diğer diller için de tüm alanları doldurup doldurmadığınızı kontrol edin.',
	'ERROR_MESSAGE_CONFIRM'				=> 'Tüm onaylama alanlarını doldurmalısınız. Lütfen diğer diller için de tüm alanları doldurup doldurmadığınızı kontrol edin.',
	'JAVASCRIPT_NOTICE'					=> 'Tüm özellikleri/ayarları kullanabilmeniz için <b>Javascript</b> aktif olmalıdır.',

	// Templates
	'ACP_SELECT_TEMPLATE'				=> 'Şablon seçiniz',
	'ACP_EDIT_TEMPLATE'					=> 'Şablonu değiştir',
	'TEMPLATE_TYPE'						=> 'Şablon türü',
	'TEMPLATE_LANGUAGE'					=> 'Şablon dili',
	'SHOW_WILDCARDS'					=> '» Olası jokerler',
	'GENERAL_WILDCARDS'					=> 'Genel',
	'USER_WILDCARDS'					=> 'İlişkili kullanıcılar',
	'WILDCARD'							=> 'Joker',
	'EXAMPLE_VALUE'						=> 'Örnek değer',
	'USER_DEFINED'						=> 'kullanıcı tarafından girilen',

	// Invitation log
	'LOG_FILTER'						=> 'Gösterim işlemi',
	'LOG_FILTER_ALL'					=> 'Tümü',
	'LOG_FILTER_INVITE'					=> 'Davetiyeler',
	'LOG_FILTER_CONFIRM'				=> 'Davetiye onayları',
	'LOG_FILTER_REGISTER'				=> 'Kayıtlar',
	'LOG_FILTER_ZEBRA'					=> 'Eklenen arkadaşlar',
	'LOG_INVITE_LOG_CLEARED'			=> '<strong>Davetiye kayıtları temizlendi</strong>',
	'LOG_INVITE_SETTINGS_UPDATED'		=> '<strong>Davetiye ayarları değiştirildi</strong>',
	'LOG_INVITE_TEMPLATES_UPDATED'		=> '<strong>Davetiye şablonları değiştirildi</strong>',
	'LOG_INVITE_INVITE'					=> '<strong>Davetiye gönderildi</strong><br/>» gönderilen kişi „%1$s“',
	'LOG_INVITE_CONFIRM'				=> '<strong>Onaylama geldi</strong><br/>» onayı  „%2$s“ kullanıcısının kayıt onayında kullanıldı.',
	'LOG_INVITE_REGISTER'				=> '<strong>Kayıt anahtarı kullanıldı</strong><br/>» bu anahtarla kaydolan „%1$s“',
	'LOG_INVITE_ZEBRA'					=> '<strong>Arkadaş eklendi</strong><br/>» eklenen kayıtlı kullanıcı „%1$s“',

	//Plugins
	'ULTIMATE_POINTS_SETTINGS'			=> 'Ultimate Points ayarları',
	'ULTIMATE_POINTS_ENABLE'			=> 'Ultimate Points’i etkinleştir',
	'ULTIMATE_POINTS_INVITE'			=> 'Davetiye başı puan',
	'ULTIMATE_POINTS_INVITE_EXPLAIN'	=> 'Her bir davetiye için verilecek puan.',
	'ULTIMATE_POINTS_REGISTER'			=> 'Kayıt başı puan',
	'ULTIMATE_POINTS_REGISTER_EXPLAIN'	=> 'Her bir kayıt için verilecek puan.',
	'CASH_SETTINGS'						=> 'Ücret ayarları',
	'CASH_ENABLE'						=> 'Ücretlendirme etkin',
	'CASH_INVITE'						=> 'Davetiye başı ücret',
	'CASH_INVITE_EXPLAIN'				=> 'Her bir davetiye için verilecek ücret.',
	'CASH_REGISTER'						=> 'Kayıt başı ücret',
	'CASH_REGISTER_EXPLAIN'				=> 'Her bir kayıt için verilecek ücret.',

	// Various stuff
	'ACC_TRANSFER'						=> 'Taşı',
	'OPTIONAL'							=> 'İsteğe bağlı',
	'INVITE_INVITE'						=> 'Davetiye',
	'INVITE_CONFIRM'					=> 'Onaylama',
	'VIEWTOPIC'							=> 'Konu',
	'MEMBERLIST_VIEW'					=> 'Profil',
	'INVITATIONS'						=> 'Davetiyeler',
	'DISPLAY_INVITER'					=> 'Davet eden',
	'DISPLAY_INVITE'					=> 'Davet edilen',
	'DISPLAY_REGISTER'					=> 'Başarılı davetiyeler',
	'MEMBERDAYS'						=> 'üyelik süresi (gün olarak)',
	'USER_LANGUAGE'						=> 'Kullanıcı dili',
	'INVITATIONS_DAY'					=> 'Gün başı %.2f davetiye',
	'INVITATIONS_PCT'					=> 'Tüm davetiyelere oranı: %.2f%%',
	'REGISTRATIONS_DAY'					=> 'Gün başı başarılı %.2f davetiye',
	'REGISTRATIONS_PCT'					=> 'Başaralı davetiyelere oranı: %.2f%%',
	'REGISTRATIONS_SUCCESS_RATE'		=> 'Kullanıcısının başarı oranı: %.2f%%',
	'SEARCH_USER_REGISTRATIONS'			=> 'Kullanıcının başarılı davetiyelerini gör',
	'PAGE_TITLE_INVITE_SEARCH'			=> '%s tarafından davet edilmiş kullanıcılar',
	'USER_ADMIN_INVITATIONS'			=> 'Kullanıcının davetiyeleri gör',
	'USER_ADMIN_REGISTRATIONS'			=> 'Kullanıcıların başarılı davetiyelerini gör',

	// Invitation settings
	'SETTINGS_ENABLE'							=> '»Invite A Friend«’i etkinleştir',
	'SETTINGS_ENABLE_KEY'						=> 'Kayıt anahtarı gereksin',
	'SETTINGS_ENABLE_KEY_EXPLAIN'				=> 'Özel panolar için kayıtları davetliler ile sınırlandırır.',
	'SETTINGS_KEY_GROUP'						=> 'Davet edilen kullanıcılar grubu',
	'SETTINGS_KEY_GROUP_EXPLAIN'				=> 'Kullanıcıların bir kayıt anahtarı girmesi durumunda seçtiğiniz gruba otomatik olarak eklenecektir.',
	'SETTINGS_KEY_GROUP_DEFAULT'				=> 'Seçili grubu varsayılan olarak ata',
	'SETTINGS_KEY_GROUP_DEFAULT_EXPLAIN'		=> 'Bir kayıt anahtarı girmiş kullanıcılar sadece bu gruba eklenmez fakat bu grup onlar için varsayılan kullanıcı grubu olarak belirlenir.',
	'SETTINGS_REMOVE_NEWLY_REGISTERED'			=> 'Yeni kayıtlı kullanıcılar grubundan çıkart',
	'SETTINGS_REMOVE_NEWLY_REGISTERED_EXPLAIN'	=> 'Bir kayıt anahtarı girmiş kullanıcıların yeni kayıtlı kullanıcılar grubundan çıkarılmasını sağlar.',
	'SETTINGS_INVITE_ACC_ACTIVATION_EXPLAIN'	=> 'Kayıt anahtarını girenler kişilerin panoya hemen erişebilmelerini veya onay gerekliliğini sağlar. Herkes gibi hesaplarını etkinleştirmelerini istiyorsanız »kullanıcı kayıt ayarları«’ndan ayarları taşıyabilirsiniz.',
	'SETTINGS_INVITE_MULTIPLE'					=> 'Çoklu davetiyeye izin ver',
	'SETTINGS_INVITE_MULTIPLE_EXPLAIN'			=> 'Aynı e-posta adresine birden fazla davetiye gönderilebilmesini istiyorsanız etkinleştirin.',
	'SETTINGS_PREVENT_ABUSE'					=> 'Art niyetli kullanımı engelle',
	'SETTINGS_PREVENT_ABUSE_EXPLAIN'			=> 'Davet edilen kişi ile davet edilen kişinin IP adresini kontrol etmeyi sağlar. Belli bir ödül sistemi kullanıyorsanız önerilir.',
	'SETTINGS_INVITE_CONFIRM_CODE'				=> 'Görsel doğrulamayı etkinleştir',
	'SETTINGS_INVITE_CONFIRM_CODE_EXPLAIN'		=> 'Otomatik davetiye yollanmasını engellemek için bu seçeneği işaretlemeniz önerilir.',
	'SETTINGS_SET_COOKIE'						=> 'Çerezleri ayarla',
	'SETTINGS_SET_COOKIE_EXPLAIN'				=> 'Çerez kullanımı sadece istatistik tutulmasını sağlamaz, aynı zamanda davet edilen kişinin panonuzda gezinebilmesini sağlar.',
	'SETTINGS_EMAIL_IDENTIFICATION'				=> 'E-posta tanımlamasına izin ver',
	'SETTINGS_EMAIL_IDENTIFICATION_EXPLAIN'		=> 'E-posta adreslerini karşılaştırarak birbiriyle ilişkili kullanıcıları belirlemeye ve istatistiki bilgilerin tuytulmasını sağlar. (Davet edilen kullanıcının bir kayıt kodu olmasa bile.)',
	'SETTINGS_INVITE_SEARCH_ALLOWED'			=> 'Üye aramaya izin ver',
	'SETTINGS_INVITE_SEARCH_ALLOWED_EXPLAIN'	=> 'Evet olarak işaretlenmesi halinde kullanıcılar davetiye seçeneklerini kullanarak üye araması yapabilir. Gösterim seçeneklerinde seçeneklerin etkinleştirilmiş olması gerekir.',
	'SETTINGS_QUEUE_TIME'						=> 'Bekleme süresi',
	'SETTINGS_QUEUE_TIME_EXPLAIN'				=> 'Bir davetiyeden sonra başka bir davetiye gönderebilmek için geçmesi gereken süre.',
	'SETTINGS_MESSAGE_CHARS'					=> 'Mesaj uzunluğu',
	'SETTINGS_MESSAGE_CHARS_EXPLAIN'			=> 'Mesajda kullanılmasını istediğiniz en az ve en çok karakter sayısı.',
	'SETTINGS_SUBJECT_CHARS'					=> 'Konu başlığı uzunluğu',
	'SETTINGS_SUBJECT_CHARS_EXPLAIN'			=> 'Konu başlığındaki kullanılmasını istediğiniz en az ve en çok karakter sayısı.',
	'SETTINGS_CONFIRM'							=> 'Onaylama gönder',
	'SETTINGS_CONFIRM_EXPLAIN'					=> 'Davetiyesi ile kayıt olan kullanıcı olması halinde davetiyeyi gönderen kişiye bir bilgilendirme postası göndermeyi sağlar.',
	'SETTINGS_ZEBRA'							=> 'Arkadaş listesine ekle',
	'SETTINGS_ZEBRA_EXPLAIN'					=> 'Davet edilen kullanıcının otomatik olarak davet eden kişinin arkadaş listesine eklenmesini sağlar.',
	'SETTINGS_INVITE_LANGUAGE_SELECT'			=> 'Davetiye dili',
	'SETTINGS_INVITE_LANGUAGE_SELECT_EXPLAIN'	=> '',
	'SETTINGS_INVITE_PRIORITY_FLAG'				=> 'Davetiye postası önemi',
	'SETTINGS_INVITE_PRIORITY_FLAG_EXPLAIN'		=> '',
	'SETTINGS_DISPLAY_NAVIGATION'				=> 'Bağlantılarda göster',
	'SETTINGS_DISPLAY_NAVIGATION_EXPLAIN'		=> '',
	'SETTINGS_DISPLAY_REGISTRATION'				=> 'Kayıt anahtarlarını göster',
	'SETTINGS_DISPLAY_REGISTRATION_EXPLAIN'		=> 'Kayıt formunda, kayıt anahtarı giriş alanının gösterilmesini sağlar.',
	'SETTINGS_AUTOHIDE_VALID_KEY'				=> 'Kayıt anahtarı giriş alanını otomatik olarak gizle',
	'SETTINGS_AUTOHIDE_VALID_KEY_EXPLAIN'		=> 'Girilen kayıt anahtarı çerez ve URL olarak doğru ise, kayıt anahtarı giriş alanı otomatik olarak gizlenecektir.',
	'SETTINGS_PROFILE_FIELDS'					=> 'İstatistikleri göster',
	'SETTINGS_PROFILE_FIELDS_EXPLAIN'			=> 'Hangi bilginin nerede gösterileceğini seçiniz',
	'SETTINGS_ADVANCED_STATISTICS'				=> 'Gelişmiş istatistikleri göster',
	'SETTINGS_ADVANCED_STATISTICS_EXPLAIN'		=> 'Profil sayfasında ek bilgileri gösterir. Kullanıcı profilindeki diğer istatistiklerin etkin olmasına gereklidir.',
	'SETTINGS_ENABLE_LIMIT_TOTAL'				=> 'Toplam sınırı etkinleştir',
	'SETTINGS_ENABLE_LIMIT_DAILY'				=> 'Günlük sınırı etkinleştir',
	'SETTINGS_LIMIT_TOTAL_BASIC'				=> 'Toplam sınır',
	'SETTINGS_LIMIT_TOTAL_BASIC_EXPLAIN'		=> 'Her bir kullanıcının gönderebileceği en fazla davetiye sayısını giriniz. Bu değer aşağıdaki ayarları etkinleştirmeniz halinde, belirtilen miktarda artacaktır.',
	'SETTINGS_LIMIT_DAILY_BASIC'				=> 'Günlük sınır',
	'SETTINGS_LIMIT_DAILY_BASIC_EXPLAIN'		=> 'Toplam sınırı aşmadıkları sürece kullanıcıların gönderebilecekleri günlük davetiye sayısını giriniz. Bu değer aşağıdaki ayarları etkinleştirmeniz halinde, belirtilen miktarda artacaktır.',
	'SETTINGS_LIMIT_POSTS'						=> 'İleti başına ek davetiye',
	'SETTINGS_LIMIT_TOPICS'						=> 'Konu başına ek davetiye',
	'SETTINGS_LIMIT_MEMBERDAYS'					=> 'Her bir üyelik günü için ek davetiye',
	'SETTINGS_LIMIT_REGISTRATIONS'				=> 'Onaylanan herbir davetiyesi için ek davetiye',

	// UMIL
	'TRANSFER_INVITATION_DATA'					=> 'Transfer old data',
	'TRANSFER_INVITATION_DATA_EXPLAIN'			=> 'Select yes to transfer statistics like the amount of invitations sent from version 0.5.4 and previous ones. The database table must not have been edited manually since that time.',
));

?>