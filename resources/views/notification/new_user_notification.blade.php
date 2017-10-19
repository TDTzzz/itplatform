<li class="notifications {{ $notification->unread() ? 'unread' : ' ' }}">
    <a href="/user/{{ $notification->data['name'] }}">
        {{ $notification->data['name'] }}
    </a> 关注了你。
</li>

