@props(['name'])
<svg {{ $attributes->merge(['viewBox'=>'0 0 24 24','fill'=>'none','stroke'=>'currentColor','stroke-width'=>'1.8','stroke-linecap'=>'round','stroke-linejoin'=>'round','aria-hidden'=>'true']) }}>
@switch($name)
    @case('shield')<path d="M12 3 20 6v5c0 5-3.4 8.3-8 10-4.6-1.7-8-5-8-10V6l8-3Z"/><path d="m8.5 12 2.2 2.2 4.8-5"/>@break
    @case('call')<path d="M7.2 3.8 10 7.2 8.2 9.4c1.3 2.6 3.8 5 6.4 6.4l2.2-1.8 3.4 2.8c.4.3.5.9.2 1.3-1 1.6-2.7 2.6-4.6 2.4C9.1 19.6 4.4 14.9 3.5 8.2c-.2-1.9.8-3.6 2.4-4.6.4-.3 1-.2 1.3.2Z"/>@break
    @case('mobile')<rect x="7" y="2.5" width="10" height="19" rx="2"/><path d="M10 5h4M11 18.5h2"/>@break
    @case('history')<path d="M4 12a8 8 0 1 0 2.3-5.7L4 8.6"/><path d="M4 4v4.6h4.6M12 7.5V12l3 2"/>@break
    @case('contacts')<path d="M5 20c.6-3.2 3.2-5 7-5s6.4 1.8 7 5"/><circle cx="12" cy="8" r="4"/><rect x="3" y="3" width="18" height="19" rx="3"/>@break
    @case('number')<rect x="6" y="3" width="12" height="18" rx="2"/><path d="M9 7h6M9 11h1M12 11h1M15 11h1M9 14h1M12 14h1M15 14h1M11 18h2"/>@break
    @case('account')<circle cx="11" cy="8" r="4"/><path d="M3.5 20c.6-4 3.2-6 7.5-6s7 2 7.5 6M19 8v6M16 11h6"/>@break
    @case('lock')<rect x="5" y="10" width="14" height="11" rx="2"/><path d="M8 10V7a4 4 0 0 1 8 0v3M12 14v3"/>@break
    @case('help')<circle cx="12" cy="12" r="9"/><path d="M9.8 9a2.4 2.4 0 1 1 3.7 2c-1 .7-1.5 1.2-1.5 2.5M12 17h.01"/>@break
    @default<circle cx="12" cy="12" r="9"/><path d="m9 12 2 2 4-4"/>
@endswitch
</svg>
