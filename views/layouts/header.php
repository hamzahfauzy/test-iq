<?php 
use yii\helpers\Url;
?>
<!--begin::Header-->
<div id="kt_header" class="header flex-column header-fixed">
    <!--begin::Top-->
    <div class="header-top">
        <!--begin::Container-->
        <div class="container">
            <!--begin::Left-->
            <div class="d-none d-lg-flex align-items-center mr-3">
                <!--begin::Logo-->
                <a href="<?=Url::to(['/'])?>" class="mr-20">
                    <img alt="Logo" src="<?=Url::to(['images/logo.png'])?>" class="max-h-35px">
                </a>
                <!--end::Logo-->
                <!--begin::Tab Navs(for desktop mode)-->
                <ul class="header-tabs nav align-self-end font-size-lg" role="tablist">
                    <!--begin::Item-->
                    <li class="nav-item">
                        <a href="#" class="nav-link py-4 px-6 <?=$this->tab_active == '' ? 'active' : '' ?>" data-toggle="tab" data-target="#kt_header_tab_1" role="tab">Home</a>
                    </li>
                    <!--end::Item-->
                    <!--begin::Item-->
                    <li class="nav-item mr-3">
                        <a href="#" class="nav-link py-4 px-6 <?=$this->tab_active == 'exams' ? 'active' : '' ?>" data-toggle="tab" data-target="#kt_header_tab_2" role="tab">Exams</a>
                    </li>
                    <!--end::Item-->
                    <!--begin::Item-->
                    <li class="nav-item mr-3">
                        <a href="#" class="nav-link py-4 px-6 <?=$this->tab_active == 'report' ? 'active' : '' ?>" data-toggle="tab" data-target="#kt_header_tab_3" role="tab">Report</a>
                    </li>
                    <!--end::Item-->
                    <!--begin::Item-->
                    <li class="nav-item mr-3">
                        <a href="#" class="nav-link py-4 px-6 <?=$this->tab_active == '' ? 'users' : '' ?>" data-toggle="tab" data-target="#kt_header_tab_4" role="tab">Users</a>
                    </li>
                    <!--end::Item-->
                </ul>
                <!--begin::Tab Navs-->
            </div>
            <!--end::Left-->
            <!--begin::Topbar-->
            <div class="topbar bg-primary">
                <!--begin::User-->
                <div class="topbar-item">
                    <div class="btn btn-icon btn-hover-transparent-white w-sm-auto d-flex align-items-center btn-lg px-2" id="kt_quick_user_toggle">
                        <div class="d-flex flex-column text-right pr-sm-3">
                            <span class="text-white opacity-50 font-weight-bold font-size-sm d-none d-sm-inline"><?=Yii::$app->user->identity->username?></span>
                            <span class="text-white font-weight-bolder font-size-sm d-none d-sm-inline">Administrator</span>
                        </div>
                        <span class="symbol symbol-35">
                            <span class="symbol-label font-size-h5 font-weight-bold text-white bg-white-o-30"><?=substr(Yii::$app->user->identity->username,0,1)?></span>
                        </span>
                    </div>
                </div>
                <!--end::User-->
            </div>
            <!--end::Topbar-->
        </div>
        <!--end::Container-->
    </div>
    <!--end::Top-->
    <!--begin::Bottom-->
    <div class="header-bottom">
        <!--begin::Container-->
        <div class="container">
            <!--begin::Header Menu Wrapper-->
            <div class="header-navs header-navs-left" id="kt_header_navs">
                <!--begin::Tab Navs(for tablet and mobile modes)-->
                <ul class="header-tabs p-5 p-lg-0 d-flex d-lg-none nav nav-bold nav-tabs" role="tablist">
                    <!--begin::Item-->
                    <li class="nav-item mr-2">
                        <a href="#" class="nav-link btn btn-clean <?=$this->tab_active == '' ? 'active' : '' ?>" data-toggle="tab" data-target="#kt_header_tab_1" role="tab">Home</a>
                    </li>
                    <!--end::Item-->
                    <!--begin::Item-->
                    <li class="nav-item mr-2">
                        <a href="#" class="nav-link btn btn-clean <?=$this->tab_active == 'exams' ? 'active' : '' ?>" data-toggle="tab" data-target="#kt_header_tab_2" role="tab">Exams</a>
                    </li>
                    <!--end::Item-->
                    <!--begin::Item-->
                    <li class="nav-item mr-2">
                        <a href="#" class="nav-link btn btn-clean <?=$this->tab_active == 'report' ? 'active' : '' ?>" data-toggle="tab" data-target="#kt_header_tab_3" role="tab">Reports</a>
                    </li>
                    <!--end::Item-->
                    <!--begin::Item-->
                    <li class="nav-item mr-2">
                        <a href="#" class="nav-link btn btn-clean <?=$this->tab_active == 'users' ? 'active' : '' ?>" data-toggle="tab" data-target="#kt_header_tab_4" role="tab">Users</a>
                    </li>
                    <!--end::Item-->
                </ul>
                <!--begin::Tab Navs-->
                <!--begin::Tab Content-->
                <div class="tab-content">
                    <!--begin::Tab Pane-->
                    <div class="tab-pane py-5 p-lg-0 <?=$this->tab_active == '' ? 'active' : '' ?>" id="kt_header_tab_1">
                        <!--begin::Menu-->
                        <div id="kt_header_menu" class="header-menu header-menu-mobile header-menu-layout-default">
                            <!--begin::Nav-->
                            <ul class="menu-nav">
                                <li class="menu-item <?=$this->menu_active == '' ? 'menu-item-active' : '' ?>" aria-haspopup="true">
                                    <a href="<?=Url::to(['/'])?>" class="menu-link">
                                        <span class="menu-text">Dashboard</span>
                                    </a>
                                </li>
                                <li class="menu-item menu-item-submenu menu-item-rel <?=$this->menu_active == 'categories' ? 'menu-item-active' : '' ?>" data-menu-toggle="click" aria-haspopup="true">
                                    <a href="javascript:;" class="menu-link menu-toggle">
                                        <span class="menu-text">Categories</span>
                                        <span class="menu-desc"></span>
                                        <i class="menu-arrow"></i>
                                    </a>
                                    <div class="menu-submenu menu-submenu-classic menu-submenu-left">
                                        <ul class="menu-subnav">
                                            <li class="menu-item">
                                                <a href="<?=Url::to(['category/create'])?>" class="menu-link">
                                                    <span class="menu-icon fas fa-plus"></span>
                                                    <span class="menu-text">Add New</span>
                                                </a>
                                            </li>
                                            <li class="menu-item">
                                                <a href="<?=Url::to(['category/index'])?>" class="menu-link">
                                                    <span class="menu-icon fas fa-list"></span>
                                                    <span class="menu-text">All Categories</span>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </li>
                                <li class="menu-item menu-item-submenu menu-item-rel <?=$this->menu_active == 'posts' ? 'menu-item-active' : '' ?>" data-menu-toggle="click" aria-haspopup="true">
                                    <a href="javascript:;" class="menu-link menu-toggle">
                                        <span class="menu-text">Posts</span>
                                        <span class="menu-desc"></span>
                                        <i class="menu-arrow"></i>
                                    </a>
                                    <div class="menu-submenu menu-submenu-classic menu-submenu-left">
                                        <ul class="menu-subnav">
                                            <li class="menu-item">
                                                <a href="<?=Url::to(['post/create'])?>" class="menu-link">
                                                    <span class="menu-icon fas fa-plus"></span>
                                                    <span class="menu-text">Add New</span>
                                                </a>
                                            </li>
                                            <li class="menu-item">
                                                <a href="<?=Url::to(['post/imports'])?>" class="menu-link">
                                                    <span class="menu-icon fas fa-upload"></span>
                                                    <span class="menu-text">Imports</span>
                                                </a>
                                            </li>
                                            <li class="menu-item">
                                                <a href="<?=Url::to(['post/index'])?>" class="menu-link">
                                                    <span class="menu-icon fas fa-list"></span>
                                                    <span class="menu-text">All Posts</span>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </li>
                                <li class="menu-item menu-item-submenu menu-item-rel <?=$this->menu_active == 'participants' ? 'menu-item-active' : '' ?>" data-menu-toggle="click" aria-haspopup="true">
                                    <a href="javascript:;" class="menu-link menu-toggle">
                                        <span class="menu-text">Participants</span>
                                        <span class="menu-desc"></span>
                                        <i class="menu-arrow"></i>
                                    </a>
                                    <div class="menu-submenu menu-submenu-classic menu-submenu-left">
                                        <ul class="menu-subnav">
                                            <li class="menu-item">
                                                <a href="<?=Url::to(['participant/create'])?>" class="menu-link">
                                                    <span class="menu-icon fas fa-plus"></span>
                                                    <span class="menu-text">Add New</span>
                                                </a>
                                            </li>
                                            <li class="menu-item">
                                                <a href="<?=Url::to(['participant/imports'])?>" class="menu-link">
                                                    <span class="menu-icon fas fa-upload"></span>
                                                    <span class="menu-text">Imports</span>
                                                </a>
                                            </li>
                                            <li class="menu-item">
                                                <a href="<?=Url::to(['participant/index'])?>" class="menu-link">
                                                    <span class="menu-icon fas fa-list"></span>
                                                    <span class="menu-text">All Participants</span>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </li>
                            </ul>
                            <!--end::Nav-->
                        </div>
                        <!--end::Menu-->
                    </div>
                    <!--begin::Tab Pane-->
                    <!--begin::Tab Pane-->
                    <div class="tab-pane py-5 p-lg-0 <?=$this->tab_active == 'exams' ? 'active' : '' ?>" id="kt_header_tab_2">
                        <!-- begin::Menu -->
                        <div id="kt_header_menu" class="header-menu header-menu-mobile header-menu-layout-default">
                            <!--begin::Nav-->
                            <ul class="menu-nav">
                                <li class="menu-item <?=$this->menu_active == 'all exams' ? 'menu-item-active' : '' ?>" aria-haspopup="true">
                                    <a href="<?=Url::to(['exam/index'])?>" class="menu-link">
                                        <span class="menu-text">All Exams</span>
                                    </a>
                                </li>
                                <li class="menu-item menu-item-submenu menu-item-rel <?=$this->menu_active == 'add new exam' ? 'menu-item-active' : '' ?>">
                                    <a href="<?=Url::to(['exam/create'])?>" class="menu-link">
                                        <span class="menu-text">Add New</span>
                                    </a>
                                </li>
                                <li class="menu-item menu-item-submenu menu-item-rel <?=$this->menu_active == 'all participants' ? 'menu-item-active' : '' ?>" data-menu-toggle="click" aria-haspopup="true">
                                    <a href="<?=Url::to(['exam/participants'])?>" class="menu-link">
                                        <span class="menu-text">All Participants</span>
                                    </a>
                                </li>
                            </ul>
                            <!--end::Nav-->
                        </div>
                        <!--end::Menu-->
                    </div>
                    <!--begin::Tab Pane-->
                    <!--begin::Tab Pane-->
                    <div class="tab-pane p-5 p-lg-0 justify-content-between" id="kt_header_tab_3">
                        <div class="d-flex flex-column flex-lg-row align-items-start align-items-lg-center">
                            <!--begin::Actions-->
                            <a href="#" class="btn btn-light-success font-weight-bold mr-3 my-2 my-lg-0">Latest Orders</a>
                            <a href="#" class="btn btn-light-primary font-weight-bold my-2 my-lg-0">Customer Service</a>
                            <!--end::Actions-->
                        </div>
                        <div class="d-flex align-items-center">
                            <!--begin::Actions-->
                            <a href="#" class="btn btn-danger font-weight-bold my-2 my-lg-0">Generate Reports</a>
                            <!--end::Actions-->
                        </div>
                    </div>
                    <!--begin::Tab Pane-->
                    <!--begin::Tab Pane-->
                    <div class="tab-pane p-5 p-lg-0 justify-content-between" id="kt_header_tab_4">
                        <div class="d-flex flex-column flex-lg-row align-items-start align-items-lg-center">
                            <!--begin::Actions-->
                            <a href="#" class="btn btn-light-success font-weight-bold mr-3 my-2 my-lg-0">Latest Orders</a>
                            <a href="#" class="btn btn-light-primary font-weight-bold my-2 my-lg-0">Customer Service</a>
                            <!--end::Actions-->
                        </div>
                        <div class="d-flex align-items-center">
                            <!--begin::Actions-->
                            <a href="#" class="btn btn-danger font-weight-bold my-2 my-lg-0">Generate Reports</a>
                            <!--end::Actions-->
                        </div>
                    </div>
                    <!--begin::Tab Pane-->
                </div>
                <!--end::Tab Content-->
            </div>
            <!--end::Header Menu Wrapper-->
        </div>
        <!--end::Container-->
    </div>
    <!--end::Bottom-->
</div>
<!--end::Header-->