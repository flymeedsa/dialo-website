@extends('layouts.admin') @section('heading',($item?'تعديل ':'إضافة ').$title) @section('content')
@php
$fields = match($type) {
'pages' => ['key'=>'مفتاح الصفحة','slug'=>'المسار','title_ar'=>'العنوان العربي','title_en'=>'العنوان الإنجليزي','excerpt_ar'=>'الوصف العربي','excerpt_en'=>'الوصف الإنجليزي','body_ar'=>'المحتوى العربي','body_en'=>'المحتوى الإنجليزي'],
'posts' => ['slug'=>'المسار','title_ar'=>'العنوان العربي','title_en'=>'العنوان الإنجليزي','excerpt_ar'=>'الملخص العربي','excerpt_en'=>'الملخص الإنجليزي','body_ar'=>'المحتوى العربي','body_en'=>'المحتوى الإنجليزي','published_at'=>'تاريخ النشر'],
'categories' => ['slug'=>'المسار','name_ar'=>'الاسم العربي','name_en'=>'الاسم الإنجليزي'],
'help-categories' => ['slug'=>'المسار','name_ar'=>'الاسم العربي','name_en'=>'الاسم الإنجليزي','sort_order'=>'الترتيب'],
'articles' => ['slug'=>'المسار','title_ar'=>'العنوان العربي','title_en'=>'العنوان الإنجليزي','excerpt_ar'=>'الملخص العربي','excerpt_en'=>'الملخص الإنجليزي','body_ar'=>'المحتوى العربي','body_en'=>'المحتوى الإنجليزي','sort_order'=>'الترتيب'],
'faqs' => ['question_ar'=>'السؤال العربي','question_en'=>'السؤال الإنجليزي','answer_ar'=>'الإجابة العربية','answer_en'=>'الإجابة الإنجليزية','sort_order'=>'الترتيب'],
};
$textareas=['excerpt_ar','excerpt_en','body_ar','body_en','answer_ar','answer_en'];
@endphp
<form class="admin-panel admin-form" method="post" action="{{ $item?route('admin.content.update',[$type,$item->id]):route('admin.content.store',$type) }}">@csrf @if($item)@method('put')@endif
@if($type==='posts')<label>التصنيف<select name="blog_category_id"><option value="">بدون تصنيف</option>@foreach($options as $id=>$name)<option value="{{ $id }}" @selected(old('blog_category_id',$item?->blog_category_id)==$id)>{{ $name }}</option>@endforeach</select></label>@endif
@if($type==='articles')<label>تصنيف المساعدة<select name="help_category_id" required>@foreach($options as $id=>$name)<option value="{{ $id }}" @selected(old('help_category_id',$item?->help_category_id)==$id)>{{ $name }}</option>@endforeach</select></label>@endif
@foreach($fields as $field=>$label)<label>{{ $label }} @if(in_array($field,['slug','key']))<small>حروف إنجليزية وأرقام وشرطات فقط</small>@endif @if(in_array($field,$textareas))<textarea name="{{ $field }}" rows="{{ str_starts_with($field,'body')?10:4 }}">{{ old($field,$item?->$field) }}</textarea>@else<input name="{{ $field }}" value="{{ old($field,$item?->$field) }}" @if($field==='sort_order')type="number" min="0"@elseif($field==='published_at')type="datetime-local"@endif></label>@endif @endforeach
@if($type==='posts')<label>الحالة<select name="status"><option value="draft" @selected(old('status',$item?->status)==='draft')>مسودة</option><option value="published" @selected(old('status',$item?->status)==='published')>منشور</option></select></label>@endif
@if(in_array($type,['pages','articles']))<label class="check-row"><input type="checkbox" name="is_published" value="1" @checked(old('is_published',$item?->is_published ?? true))> منشور</label>@endif
@if(in_array($type,['help-categories','faqs']))<label class="check-row"><input type="checkbox" name="is_visible" value="1" @checked(old('is_visible',$item?->is_visible ?? true))> ظاهر</label>@endif
<div class="button-row"><button class="button primary">حفظ</button><a class="button secondary" href="{{ route('admin.content.index',$type) }}">إلغاء</a></div></form>@endsection
