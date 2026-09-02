<?php

namespace Database\Seeders;

use App\Models\BlogCategory;
use App\Models\BlogPost;
use App\Models\Faq;
use App\Models\HelpArticle;
use App\Models\HelpCategory;
use App\Models\Page;
use App\Models\SiteSetting;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $pages = [
            ['features', 'features', 'مزايا Dialo', 'Dialo features', 'مكالمات صوتية واضحة بهوية رقم Dialo خاصة.', 'Clear voice calling with your own Dialo number.', 'يمنحك Dialo رقمًا من 10 أرقام يبدأ بـ 08. تستخدمه للاتصال الصوتي بمستخدمي Dialo الآخرين عبر الإنترنت. Dialo 1.0 لا يتضمن الفيديو أو الرسائل أو الاتصال بالشبكات العامة.', 'Dialo gives you a 10-digit number beginning with 08. Use it for Internet voice calls to other Dialo users. Dialo 1.0 does not include video, messaging, or public carrier calling.'],
            ['how-dialo-works', 'how-dialo-works', 'كيف يعمل Dialo', 'How Dialo works', 'من رقم Dialo إلى مكالمة صوتية عبر الإنترنت.', 'From a Dialo number to an Internet voice call.', 'يُخصص رقم Dialo من المخزون المركزي، ثم تستخدم التطبيق لإدخال رقم Dialo آخر أو اختيار جهة اتصال محفوظة. تعالج بنية WebRTC الصوت أثناء المكالمة عبر الإنترنت.', 'A Dialo number is allocated from central inventory. Enter another Dialo number or choose a saved contact, then WebRTC handles the voice call over the Internet.'],
            ['security', 'security', 'الأمان والخصوصية', 'Security and privacy', 'تقنية مسؤولة وشرح واضح بلا مبالغة.', 'Responsible technology, explained without overclaiming.', 'يستخدم Dialo WebRTC مع DTLS-SRTP لحماية نقل الوسائط، ويلجأ إلى TURN عند الحاجة. يحتفظ الخادم ببيانات الإشارة وحالة المكالمة اللازمة لتشغيل الخدمة، ولا يوفر Dialo حاليًا تسجيل المكالمات.', 'Dialo uses WebRTC with DTLS-SRTP to protect media transport and TURN when needed. The server handles signaling and call-state metadata required to operate the service. Dialo does not currently offer call recording.'],
            ['privacy', 'privacy', 'سياسة الخصوصية', 'Privacy Policy', 'نوضح هنا طريقة تعامل موقع Dialo مع البيانات.', 'How the Dialo website handles data.', 'هذه نسخة أولية معلوماتية وليست ادعاءً بالموافقة القانونية النهائية. يجمع نموذج التواصل البيانات التي ترسلها لمعالجة طلبك. يجب مراجعة هذه السياسة قانونيًا قبل الإطلاق العام.', 'This is an initial informational draft and not a claim of final legal approval. The contact form collects the information you submit. Legal review is required before public launch.'],
            ['terms', 'terms', 'شروط الاستخدام', 'Terms of Use', 'شروط أولية لموقع Dialo العام.', 'Initial terms for the public Dialo website.', 'المحتوى الحالي تعريفي. Dialo ليس بديلًا لخدمات الطوارئ أو لشبكات الهاتف العامة. يجب اعتماد صياغة قانونية نهائية قبل الإطلاق العام.', 'Current content is informational. Dialo is not a replacement for emergency services or public telephone networks. Final legal wording must be approved before public launch.'],
            ['cookies', 'cookies', 'معلومات ملفات الارتباط', 'Cookie Information', 'استخدام محدود وضروري لملفات الارتباط.', 'Limited, necessary use of cookies.', 'يستخدم الموقع ملفات جلسة ضرورية للحماية وتسجيل الدخول إلى لوحة الإدارة. أي أدوات تحليل إضافية يجب الإفصاح عنها قبل تفعيلها.', 'The website uses essential session cookies for security and CMS login. Any future analytics must be disclosed before activation.'],
        ];
        foreach ($pages as [$key,$slug,$titleAr,$titleEn,$excerptAr,$excerptEn,$bodyAr,$bodyEn]) {
            Page::updateOrCreate(['key' => $key], ['slug' => $slug, 'title_ar' => $titleAr, 'title_en' => $titleEn, 'excerpt_ar' => $excerptAr, 'excerpt_en' => $excerptEn, 'body_ar' => $bodyAr, 'body_en' => $bodyEn, 'is_published' => true]);
        }

        $category = BlogCategory::updateOrCreate(['slug' => 'product'], ['name_ar' => 'المنتج', 'name_en' => 'Product']);
        BlogPost::updateOrCreate(['slug' => 'welcome-to-dialo'], ['blog_category_id' => $category->id, 'title_ar' => 'مرحبًا بكم في Dialo', 'title_en' => 'Welcome to Dialo', 'excerpt_ar' => 'تعريف واضح بتجربة الاتصال الصوتي من Dialo إلى Dialo.', 'excerpt_en' => 'A clear introduction to Dialo-to-Dialo voice calling.', 'body_ar' => 'نبني Dialo ليمنح كل مستخدم رقمًا شخصيًا واضحًا للاتصال الصوتي عبر الإنترنت بمستخدمي Dialo الآخرين. سننشر أخبار الإتاحة الرسمية هنا عند جاهزيتها.', 'body_en' => 'Dialo is being built to give each user a clear personal number for Internet voice calls to other Dialo users. Official availability updates will be posted here when ready.', 'status' => 'published', 'published_at' => now()]);

        $help = [
            ['getting-started', 'البدء', 'Getting started', 'what-is-dialo', 'ما هو Dialo؟', 'What is Dialo?', 'Dialo تطبيق مكالمات صوتية عبر الإنترنت بين مستخدمي Dialo.', 'Dialo is an Internet voice calling app for Dialo users.'],
            ['numbers', 'أرقام Dialo', 'Dialo numbers', 'dialo-number-format', 'كيف يبدو رقم Dialo؟', 'What does a Dialo number look like?', 'رقم Dialo يتكون من 10 أرقام ويبدأ بـ 08، ويظهر مثل 0800 905 066.', 'A Dialo number has 10 digits, begins with 08, and displays like 0800 905 066.'],
            ['calling', 'المكالمات', 'Calling', 'who-can-i-call', 'بمن يمكنني الاتصال؟', 'Who can I call?', 'يمكنك الاتصال بمستخدم Dialo آخر عبر الإنترنت. الاتصال بأرقام الجوال والشبكات العامة غير مدعوم.', 'You can call another Dialo user over the Internet. Public mobile and carrier numbers are not supported.'],
            ['privacy', 'الخصوصية', 'Privacy', 'caller-identity', 'ما الذي يظهر للمتلقي؟', 'What does the recipient see?', 'إذا لم يحفظ المتلقي رقمك محليًا، يظهر له رقم Dialo بدل تحويل اسم حسابك إلى هوية عامة.', 'If the recipient has not saved you locally, they see your Dialo number rather than a public account identity.'],
        ];
        foreach ($help as $order => [$catSlug,$catAr,$catEn,$slug,$titleAr,$titleEn,$bodyAr,$bodyEn]) {
            $helpCategory = HelpCategory::updateOrCreate(['slug' => $catSlug], ['name_ar' => $catAr, 'name_en' => $catEn, 'sort_order' => $order, 'is_visible' => true]);
            HelpArticle::updateOrCreate(['slug' => $slug], ['help_category_id' => $helpCategory->id, 'title_ar' => $titleAr, 'title_en' => $titleEn, 'excerpt_ar' => $bodyAr, 'excerpt_en' => $bodyEn, 'body_ar' => $bodyAr, 'body_en' => $bodyEn, 'sort_order' => 0, 'is_published' => true]);
        }

        foreach ([
            ['هل يتصل Dialo بأرقام الجوال؟', 'Does Dialo call mobile numbers?', 'لا. Dialo 1.0 للاتصال بين مستخدمي Dialo عبر الإنترنت فقط.', 'No. Dialo 1.0 supports Internet calls between Dialo users only.'],
            ['هل يدعم Dialo الفيديو أو الرسائل؟', 'Does Dialo support video or messaging?', 'لا. الإصدار 1.0 صوتي فقط.', 'No. Version 1.0 is voice only.'],
            ['هل يسجل Dialo المكالمات؟', 'Does Dialo record calls?', 'لا يوفر Dialo حاليًا تسجيل المكالمات.', 'Dialo does not currently provide call recording.'],
            ['هل رقم Dialo رقم جوال؟', 'Is a Dialo number a mobile number?', 'لا. هو معرّف اتصال خاص بتطبيق Dialo ولا يحمل رمز دولة.', 'No. It is a Dialo app calling identifier and has no country code.'],
            ['هل يعمل Dialo على Wi-Fi؟', 'Does Dialo work on Wi-Fi?', 'نعم. يحتاج Dialo إلى اتصال بالإنترنت لإجراء المكالمات بين مستخدميه.', 'Yes. Dialo needs an Internet connection to place calls between Dialo users.'],
            ['هل يمكنني اختيار أي رقم؟', 'Can I choose any number?', 'لا تُكتب الأرقام أو تُحجز عشوائيًا؛ يخصص Dialo الأرقام المتاحة من المخزون المركزي.', 'Numbers cannot be typed or claimed arbitrarily; Dialo allocates available numbers from its central inventory.'],
        ] as $order => $faq) {
            Faq::updateOrCreate(['question_en' => $faq[1]], ['question_ar' => $faq[0], 'answer_ar' => $faq[2], 'answer_en' => $faq[3], 'sort_order' => $order, 'is_visible' => true]);
        }

        foreach (['site_name_ar' => 'Dialo', 'site_name_en' => 'Dialo', 'downloads_enabled' => '0'] as $key => $value) {
            SiteSetting::updateOrCreate(['key' => $key], ['value' => $value]);
        }
        if (env('WEBSITE_ADMIN_EMAIL') && env('WEBSITE_ADMIN_PASSWORD')) {
            User::updateOrCreate(['email' => env('WEBSITE_ADMIN_EMAIL')], ['name' => env('WEBSITE_ADMIN_NAME', 'Website Admin'), 'password' => env('WEBSITE_ADMIN_PASSWORD'), 'is_admin' => true, 'locale' => 'ar']);
        }
    }
}
