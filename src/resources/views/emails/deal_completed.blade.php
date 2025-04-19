@component('mail::message')
# 商品取引完了のお知らせ

{{ $item->item_name }} の取引が、{{ $buyer->name }} さんによって完了しました。

**取引詳細:**
- 商品名: {{ $item->item_name }}
- 購入者: {{ $buyer->name }}
- 取引ID: {{ $purchase->id }}

出品者様は、この取引についてご確認ください。

@component('mail::button', ['url' => url('/purchase/deal/' . $item->id)])
商品ページを確認する
@endcomponent

ありがとうございます。
{{ config('app.name') }}
@endcomponent