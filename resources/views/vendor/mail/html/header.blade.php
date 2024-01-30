@props(['url'])
<tr>
<td class="header">
<a href="{{ $url }}" style="display: inline-block;">
@if (trim($slot) === 'Laravel')
<img src="https://i.imgur.com/uYo5374.png" class="logo" alt="YARG Logo">
@else
{{ $slot }}
@endif
</a>
</td>
</tr>
