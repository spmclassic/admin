<ul class="top-suspension">
    <li class="li-left top-picture">
        <a href="javascript:;">
            <img src="/images/basicprofile" alt=""/>
        </a>
    </li>
    <li class="li-left sixty"><a href=""> <i class="iconfont">&#xe640;</i></a></li>
    <li class="li-left sixty"><a href="#"> <i class="iconfont">&#xe604;</i></a></li>
    <li class="li-right hundred-three">
        {{$user['name'] ?? ' -- '}}<sup></sup>
        <div class="account-information" style="bottom: -34px;">
            <a href="{{url('logout')}}">退出</a>
        </div>
    </li>

</ul>
@inject('system','App\Presenters\Common\MenuPresenter')
<?php $items = $system->init(config('app.guard.admin'));?>

<div class="nav_wrap_ch">

    <div class="nav_first_ch">
        <ul>
            @foreach ($items as $item)
                <?php $item = $system->currentMenu($item);?>
                <a href="{{$system->getNodeLink($item)}}" target="_self">
                    <li  class="{!! $item['current'] ?? '' !!}">
                        {!! $item['icon_class'] ?? '' !!}
                        {!! $item['display_name'] ?? '' !!}
                    </li>
                </a>
            @endforeach
        </ul>
    </div>
    <?php $menu = $items->where('current','on')->first(); ?>
    @if(!empty($menu) && !empty($menu->node))
        @if(!$menu->node->isEmpty())
            <div class="nav_second_ch">
                <ul class="nav_left_second sidenav">
                    @foreach($menu->node as $second)
                        <?php $second = $system->currentMenu($second,2);?>
                        <li class="{{$second['current'] ?? ''}}" >
                            <div class='nav_tit @if($second['current'] == 'on') selected @endif'>
                                <a href='{!! $system->link($second->name) !!}'>{!! $second['display_name'] ?? '二级菜单' !!} ></a>
                            </div>
                            <div class='nav_children'>
                                @foreach($second->node as $node)
                                    <?php $node = $system->currentMenu($node,3);?>
                                    <a href="{{$system->link($node->name)}}" class="@if($node['current'] == 'on') current @endif">
                                        {!! $node['display_name'] ?? '' !!}
                                    </a>
                                @endforeach
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
        @endif
    @endif

</div>

