@props(['screen' => 'dialpad', 'tilt' => 'none'])
<div {{ $attributes->class(['phone-mockup','tilt-left'=>$tilt==='left','tilt-right'=>$tilt==='right']) }}>
    <div class="phone-speaker"></div>
    <div class="phone-screen {{ $screen }}">
        <div class="phone-status"><span>9:41</span><span>● ◒ ▰</span></div>
        @if($screen === 'dialpad')
            <p class="screen-kicker">{{ app()->getLocale()==='ar'?'أدخل رقم Dialo':'Enter Dialo number' }}</p>
            <strong class="screen-number" dir="ltr">0800 905 066</strong>
            <div class="dial-grid">@foreach([1,2,3,4,5,6,7,8,9,'*',0,'#'] as $key)<span>{{ $key }}</span>@endforeach</div>
            <span class="round-call">☎</span>
        @elseif($screen === 'contacts')
            <h3>{{ app()->getLocale()==='ar'?'جهات الاتصال':'Contacts' }}</h3>
            <div class="fake-search">{{ app()->getLocale()==='ar'?'ابحث في جهاتك':'Search contacts' }}</div>
            @foreach([['أحمد السالمي','0800 123 456'],['سارة الحسن','0800 987 654'],['محمد الحربي','0800 111 222']] as $contact)
                <div class="contact-row"><span class="avatar">{{ mb_substr($contact[0],0,1) }}</span><span><b>{{ app()->getLocale()==='ar'?$contact[0]:match($loop->iteration){1=>'Ahmed Ali',2=>'Sarah Hassan',default=>'Mohammed Ahmed'} }}</b><small dir="ltr">{{ $contact[1] }}</small></span><i>☎</i></div>
            @endforeach
        @else
            <p class="screen-kicker">{{ $screen==='incoming' ? (app()->getLocale()==='ar'?'مكالمة واردة':'Incoming call') : (app()->getLocale()==='ar'?'مكالمة جارية':'In call') }}</p>
            <span class="caller-avatar">S</span>
            <h3>{{ app()->getLocale()==='ar'?'سارة الحسن':'Sarah Hassan' }}</h3>
            <strong dir="ltr">0800 987 654</strong>
            @if($screen==='incall')<small class="call-duration">00:32</small>@endif
            <div class="call-controls"><span>◖<small>{{ app()->getLocale()==='ar'?'كتم':'Mute' }}</small></span><span>⌨<small>{{ app()->getLocale()==='ar'?'لوحة':'Keypad' }}</small></span><span>◗<small>{{ app()->getLocale()==='ar'?'صوت':'Audio' }}</small></span></div>
            <div class="answer-row">@if($screen==='incoming')<span class="hangup">☎</span>@endif<span class="answer">☎</span></div>
        @endif
        <div class="phone-home"></div>
    </div>
</div>
