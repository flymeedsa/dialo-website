@extends('layouts.public')
@section('title', __('messages.nav.contact').' — Dialo')
@section('content')
<section class="page-hero inner-page-hero"><div class="container narrow"><span class="eyebrow">DIALO SUPPORT</span><h1>{{ __('messages.nav.contact') }}</h1><p>{{ app()->getLocale()==='ar'?'أرسل استفسارك لفريق الموقع. لا ترسل كلمات مرور أو معلومات حساسة.':'Send your question to the website team. Never include passwords or sensitive information.' }}</p></div></section>
<section class="section inner-content-section"><div class="container contact-layout">
    <form class="contact-form elevated-form" method="post" action="{{ route(app()->getLocale().'.contact.store') }}">@csrf
        @if(session('success'))<div class="alert success">{{ session('success') }}</div>@endif
        @if($errors->any())<div class="alert error">{{ app()->getLocale()==='ar'?'تحقق من الحقول المطلوبة.':'Please check the required fields.' }}</div>@endif
        <div class="honeypot"><label>Website<input name="website" tabindex="-1" autocomplete="off"></label></div>
        <div class="form-row"><label>{{ app()->getLocale()==='ar'?'الاسم':'Name' }}<input name="name" value="{{ old('name') }}" required maxlength="120"></label><label>{{ app()->getLocale()==='ar'?'البريد الإلكتروني':'Email' }}<input type="email" name="email" value="{{ old('email') }}" required></label></div>
        <label>{{ app()->getLocale()==='ar'?'الموضوع':'Subject' }}<input name="subject" value="{{ old('subject') }}" required maxlength="180"></label>
        <label>{{ app()->getLocale()==='ar'?'الرسالة':'Message' }}<textarea name="message" rows="7" required maxlength="5000">{{ old('message') }}</textarea></label>
        <button class="button primary">{{ app()->getLocale()==='ar'?'إرسال الرسالة':'Send message' }}</button>
    </form>
    <aside class="support-aside"><span class="approved-icon"><x-site-icon name="shield" /></span><h2>{{ app()->getLocale()==='ar'?'قبل أن ترسل':'Before you send' }}</h2><ul><li>{{ app()->getLocale()==='ar'?'لا ترسل كلمة مرور أو رمز تحقق.':'Never send a password or verification code.' }}</li><li>{{ app()->getLocale()==='ar'?'اشرح المشكلة باختصار ووضوح.':'Describe the issue briefly and clearly.' }}</li><li>{{ app()->getLocale()==='ar'?'للمساعدة العامة راجع مركز المساعدة أولًا.':'Check the Help Center first for common questions.' }}</li></ul><a class="button secondary" href="{{ route(app()->getLocale().'.help') }}">{{ __('messages.nav.help') }}</a></aside>
</div></section>
@endsection
