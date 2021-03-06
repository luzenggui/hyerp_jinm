<nav class="navbar navbar-default navbar-static-top">
    <div class="container-fluid">
        <div class="navbar-header">

            <!-- Collapsed Hamburger -->
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                <span class="sr-only">Toggle Navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>

            <!-- Branding Image -->
            <a class="navbar-brand" href="{{ url('/') }}">            
                {{ config('app.name', 'Laravel') }}
                <!-- <img alt="Brand" src="/images/logo.png" width="30" height="30"> -->
            </a>
        </div>

        <div class="collapse navbar-collapse" id="app-navbar-collapse">
            <!-- Left Side Of Navbar -->
            <ul class="nav navbar-nav">
            @unless (Auth::guest())
                {{--<li class="dropdown">--}}
                    {{--<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">基础资料<span class="caret"></span></a>--}}
                    {{--<ul class="dropdown-menu">--}}
                        {{--@can('module_product')--}}
                        {{--<li><a href="/product/items">物料</a></li>--}}
                        {{--<li><a href="/product/itemclasses">物料类别</a></li>--}}
                        {{--<li><a href="/product/boms">物料清单</a></li>--}}
                        {{--@endcan--}}
                            {{--@can('product_item_purchase_view')--}}
                                {{--<li><a href="/product/indexp_hxold/">购入零件</a></li>--}}
                            {{--@endcan--}}
                    {{--</ul>--}}
                {{--</li>--}}
                {{--<li class="dropdown">--}}
                    {{--<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">库存<span class="caret"></span></a>--}}
                    {{--<ul class="dropdown-menu">--}}
                        {{--@can('module_inventory')--}}
                        {{--<li><a href="/inventory/warehouses">仓库</a></li>--}}
                        {{--<li role="separator" class="divider"></li>--}}
                        {{--@can('inventory_batch_search')--}}
                            {{--<li><a href="/inventory/report">报表</a></li>--}}
                        {{--@endcan--}}
                        {{--@endcan--}}
                    {{--</ul>--}}
                {{--</li>--}}
                {{--<li class="dropdown">--}}
                    {{--<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">销售<span class="caret"></span></a>--}}
                    {{--<ul class="dropdown-menu">--}}
                        {{--@can('module_sales')--}}
                        {{--<li><a href="/sales/salesorders">销售订单</a></li>--}}
                            {{--<li><a href="/sales/salesorderhx">销售订单</a></li>--}}
                        {{--<li><a href="/sales/custinfos">客户</a></li>--}}
                        {{--<li role="separator" class="divider"></li>--}}
                        {{--<li><a href="/inventory/inventoryAvailabilityBySalesorder">库存可用量</a></li>--}}
                            {{--<li><a href="/sales/report">报表</a></li>--}}
                        {{--@if (Auth::user()->isSuperAdmin())--}}
                                {{--<li><a href="/sales/report2/bonusbysalesmanager">销售人员奖金报表</a></li>--}}
                                {{--<li><a href="/sales/report2/bonusbytechdept">技术人员奖金报表</a></li>--}}
                                {{--<li><a href="/my/bonus/byorder">销售人员奖金（按订单）</a></li>--}}
                        {{--@endif--}}
                        {{--@endcan--}}
                    {{--</ul>--}}
                {{--</li>--}}
                    {{--<li class="dropdown">--}}
                        {{--<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">客户采购订单<span class="caret"></span></a>--}}
                        {{--<ul class="dropdown-menu">--}}
                            {{--@can('module_customerpurchase')--}}
                                {{--<li><a href="/purchaseorderc/purchaseordercs">采购订单</a></li>--}}
                                {{--<li><a href="/purchaseorderc/poheadcreceives">历史订单</a></li>--}}
                            {{--@endcan--}}
                        {{--</ul>--}}
                    {{--</li>--}}
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">发展部<span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            @can('module_fabricdischarge')
                                <li><a href="/development/fabricdischarges">排料申请单</a></li>
                                <li><a href="/development/genbarcode">UPC条码批量生成</a></li>
                                <li><a href="/development/report">报表</a></li>
                            @endcan
                        </ul>
                    </li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">第六分公司<span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            @can('module_department6')
                                <li><a href="/department6/ingredient">辅料资料维护</a></li>
                                <li><a href="/department6/part">部位资料维护</a></li>
                                <li><a href="/department6/process">加工资料维护</a></li>
                                <li><a href="/department6/inquiry_sheets">询价单</a></li>
                                <li><a href="/department6/orders">大货订单</a></li>
                                <li><a href="/department6/report">报表</a></li>
                            @endcan
                        </ul>
                    </li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">行政部<span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            @can('module_personal')
                                <li><a href="/personal/checkrecords">移动端考勤信息</a></li>
                                <li><a href="/personal/orgmembers">员工信息</a></li>
                                <li><a href="/personal/report">报表</a></li>
                            @endcan
                        </ul>
                    </li>

                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">财务部<span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            @can('module_finance')
                                <li><a href="/finance/shipmentinfo">出运明细信息维护</a></li>
                                <li><a href="/finance/packinfo">装箱信息维护</a></li>
                                <li><a href="/finance/invoice">发票信息维护</a></li>
                                <li><a href="/finance/nxshipment">内销出运明细信息维护</a></li>
                                <li><a href="/finance/report">报表</a></li>
                            @endcan
                        </ul>
                    </li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">JPTE单证<span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            @can('module_vouch')
                                <li><a href="/vouch/materials">原材料代码表</a></li>
                                <li><a href="/vouch/finishproducts">成品代码表</a></li>
                                <li><a href="/vouch/boms">BOM表</a></li>
                                <li><a href="/vouch/materialsheets">原材料表单</a></li>
                                <li><a href="/vouch/finishproductsheets">成品表单</a></li>
                                <li><a href="/shipment/packinglists">宠物单证装箱明细</a></li>
                                <li><a href="/vouch/report">报表</a></li>
                            @endcan
                        </ul>
                    </li>
                {{--<li class="dropdown">--}}
                    {{--<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">采购<span class="caret"></span></a>--}}
                    {{--<ul class="dropdown-menu">--}}
                        {{--@can('vendor')--}}
                            {{--<li><a href="/purchase/purchaseorders">采购订单</a></li>--}}
                            {{--<li><a href="/purchase/asns">ASN</a></li>--}}
                        {{--@endcan--}}
                        {{--@can('module_purchase')--}}
                            {{--<li><a href="/purchase/vendors">供应商</a></li>--}}
                            {{--<li role="separator" class="divider"></li>--}}
                            {{--<li><a href="/purchase/uservendors">供应商设置</a></li>--}}
                        {{--<li><a href="/purchase/report">报表</a></li>--}}
                        {{--@endcan--}}
                    {{--</ul>--}}
                {{--</li>--}}
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">出运单(Shipment Management)<span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            @can('module_shipment')
                                <li><a href="/shipment/shipments">出运跟踪(Shipment Tracking)</a></li>
                                {{--<li><a href="/shipment/shipments/filemonitor">文件监控(File Monitor)</a></li>--}}
                            @endcan
                            {{--@can('forwarder')--}}
                                {{--<li><a href="/shipment/shipments/shipmenttracking">货代跟踪(Forwarder Tracking)</a></li>--}}
                            {{--@endcan--}}
                                @can('module_shipment')
                                <li role="separator" class="divider"></li>
                                <li><a href="/shipment/report">报表(Report)</a></li>
                                {{--<li role="separator" class="divider"></li>--}}
                                {{--<li><a href="/shipment/userforwarders">设置货代(Setting Forwarder)</a></li>--}}
                            @endcan
                        </ul>
                    </li>
                {{--<li class="dropdown">--}}
                    {{--<a class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">客户关系<span class="caret"></span></a>--}}
                    {{--<ul class="dropdown-menu">--}}
                        {{--@can('module_crm')--}}
                        {{-- <li><a href="/crmaddounts">账户</a></li> --}}
                        {{--<li><a href="/crm/contacts">联系人</a></li>--}}
                        {{--<li><a href="/addr/addrs">地址</a></li>--}}
                        {{--@endcan--}}
                    {{--</ul>--}}
                {{--</li>--}}
                {{--<li class="dropdown">--}}
                    {{--<a class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">财务<span class="caret"></span></a>--}}
                    {{--<ul class="dropdown-menu">--}}
                        {{--@can('module_accounting')--}}
                        {{--<li><a href="/accounting/receivables">应收</a></li>--}}
                        {{--<li><a href="/accounting/payables">应付</a></li>--}}
                        {{--@endcan--}}
                    {{--</ul>--}}
                {{--</li>--}}
                {{--<li class="dropdown">--}}
                    {{--<a class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">审批<span class="caret"></span></a>--}}
                    {{--<ul class="dropdown-menu">--}}
                        {{--@can('module_approval')--}}
                        {{--<li><a href="/approval/reimbursements">报销</a></li>--}}
                        {{--@endcan--}}
                        {{--@can('approval_paymentrequest_view')--}}
                        {{--<li><a href="/approval/paymentrequests">供应商付款</a></li>--}}
                        {{--@endcan--}}
                        {{--@can('module_approval')--}}
{{--@if (isset(Auth::user()->email) and Auth::user()->email == "admin@admin.com")--}}
                        {{--<li><a href="/approval/paymentrequestapprovals">供应商付款审批记录</a></li>--}}
                                    {{--@can('approval_issuedrawing_view')--}}
                                        {{--<li><a href="/approval/issuedrawing">下发图纸</a></li>--}}
                                    {{--@endcan--}}
{{--@endif--}}
    {{--@can('approval_synchronize')--}}
                            {{--<li><a href="/approval/synchronize">审批同步（钉钉）</a></li>--}}
    {{--@endcan--}}
                        {{--<li role="separator" class="divider"></li>--}}
                        {{--<li><a href="/approval/approversettings">设置</a></li>--}}
    {{--<li role="separator" class="divider"></li>--}}
                        {{--<li><a href="/approval/report">报表</a></li>--}}
    {{--@if (Auth::user()->isSuperAdmin())--}}
        {{--<li><a href="/approval/report2/issuedrawingpurchasedetail">下图申购结算明细报表</a></li>--}}
    {{--@endif--}}
                        {{--@endcan--}}
                    {{--</ul>--}}
                {{--</li>--}}
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">系统<span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        @can('module_system')
                        {{--<li><a href="/system/employees">员工</a></li>--}}
                        <li><a href="/system/users">用户管理</a></li>
                        @endcan
                        @if (Auth::user()->email === "admin@admin.com")
                            <li><a href="/system/reports">报表</a></li>
                        @endif
                        {{-- <li><a href="/system/permissions">权限管理</a></li> --}}
                    </ul>
                </li>
            @endunless
            </ul>

            <!-- Right Side Of Navbar -->
            <ul class="nav navbar-nav navbar-right">
                <!-- Authentication Links -->
                @if (Auth::guest())
                    <li><a href="{{ url('/login') }}">登录</a></li>
                    <li><a href="{{ url('/register') }}">注册</a></li>
                @else
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                            {{ Auth::user()->name }} <span class="caret"></span>
                        </a>

                        <ul class="dropdown-menu" role="menu">
                            <li><a href="{{ url('/logout') }}"><i class="fa fa-btn fa-sign-out"></i>退出登录</a></li>
                            {{--<li>--}}
                                {{--{!! Form::open(['url' => '/logout']) !!}--}}
                                {{--{!! Form::submit('退出登录') !!}--}}
                                {{--{!! Form::close() !!}--}}
                            {{--</li>--}}

                            @if (Auth::user()->email === "admin@admin.com")
                                <li><a href="{{ url('/changeuser') }}"><i class="fa fa-btn fa-sign-out"></i>切换用户</a></li>
                            @endif
                        </ul>
                    </li>
                @endif
            </ul>
        </div>
    </div>
</nav>