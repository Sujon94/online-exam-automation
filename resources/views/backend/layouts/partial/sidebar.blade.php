<?php
/**
 *Created by PhpStorm
 *Created at ৭/৯/২১ ৩:২৭ PM
 */
?>
<div class="vertical-menu">

    <div data-simplebar class="h-100">

        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <!-- Left Menu Start -->
            <ul class="metismenu list-unstyled" id="side-menu">
                <li class="menu-title" key="t-menu">Menu</li>
                <li>
                    <a href="{{route('dashboard')}}" class="waves-effect">
                        <i class="bx bx-home-circle"></i>{{--<span class="badge rounded-pill bg-info float-end">04</span>--}}
                        <span key="t-dashboards">Dashboard</span>
                    </a>{{--
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="index.html" key="t-default">Default</a></li>
                        <li><a href="dashboard-saas.html" key="t-saas">Saas</a></li>
                        <li><a href="dashboard-crypto.html" key="t-crypto">Crypto</a></li>
                        <li><a href="dashboard-blog.html" key="t-blog">Blog</a></li>
                    </ul>--}}
                </li>
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="bx bx-wrench"></i>
                        <span key="">Setup</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('page-setup.index') }}" key="t-pages">Pages</a></li>
                        <li><a href="{{ route('course-type-setup.index') }}" key="">Course Type</a></li>
                        <li><a href="{{ route('post-category-setup.index') }}" key="">Post Category</a></li>
                        <li><a href="{{ route('course-ui.index') }}" key="t-products">Course Master UI</a></li>
                        <li><a href="{{ route('service-ui.index') }}" key="t-products">Service Master UI</a></li>
                        <li><a href="{{ route('web-setting.appearance-setup') }}" key="t-products">Appearance</a></li>
                        <li>
                            <a href="javascript: void(0);" class="has-arrow waves-effect">
                                <i class="bx bx-wrench"></i>
                                <span key="">Exam Conigure</span>
                            </a>
                            <ul class="sub-menu" aria-expanded="false">
                                <li><a href="{{ route('setup.topic-index') }}" key="">Topic Setup</a></li>
                                <li><a href="{{ route('setup.subject-index') }}" key="">Subject Setup</a></li>
                            </ul>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="bx bx-user-voice"></i>
                        <span key="t-circular">Circular</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('circular-setup.index') }}" key="t-circular">Circular Setup</a></li>
                    </ul>
                </li>
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="bx bx-user-plus"></i>
                        <span key="t-circular">Trainer</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('trainer-setup.index') }}" key="t-trainer">Trainer Setup</a></li>
                    </ul>
                </li>
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="bx bx-book-content"></i>
                        <span key="t-ecommerce">Course</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('course-setup.index') }}" key="t-products">Course Setup</a></li>
                        <li><a href="{{ route('course-trainers-map.index') }}" key="t-products">Course Trainer Map</a></li>
                    </ul>
                </li>
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="bx bx-grid"></i>
                        <span key="">Batch</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('batch-setup.index') }}" key="">Batch Setup</a></li>
                        <li><a href="{{ route('batch-schedule.index') }}" key="">Batch Schedule</a></li>
                    </ul>
                </li>
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="bx bx-book-content"></i>
                        <span key="">Exam System</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li>
                            <a href="javascript: void(0);" class="has-arrow waves-effect">
                                <i class="bx bx-grid"></i>
                                <span key="">Question</span>
                            </a>
                            <ul class="sub-menu" aria-expanded="false">
                                <li><a href="{{ route('question.index') }}" key="">Create Question</a></li>
                                <li><a href="{{ route('question.list') }}" key="">List</a></li>
                            </ul>
                        </li>
                        <li>
                            <a href="javascript: void(0);" class="has-arrow waves-effect">
                                <i class="bx bx-grid"></i>
                                <span key="">Exam</span>
                            </a>
                            <ul class="sub-menu" aria-expanded="false">
                                <li><a href="{{ route('exam.index') }}" key="">Create Exam</a></li>
                                <li><a href="{{ route('exam.list') }}" key="">List</a></li>
                            </ul>
                        </li>
                        <li>
                            <a href="javascript: void(0);" class="has-arrow waves-effect">
                                <i class="bx bx-grid"></i>
                                <span key="">Exam Result</span>
                            </a>
                            <ul class="sub-menu" aria-expanded="false">
                                <li><a href="{{ route('exam.result') }}" key="">Result</a></li>
<!--                                <li><a href="{{ route('exam.list') }}" key="">Process</a></li>-->
                            </ul>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="bx bxs-graduation"></i>
                        <span key="">Student</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('student.index') }}" key="">Student</a></li>
                        <li><a href="{{ route('student-transaction.index') }}" key="">Transactions</a></li>
                    </ul>
                </li>
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="bx bxs-pencil"></i>
                        <span key="">Post</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('post-write.index') }}" key="">Post</a></li>
                    </ul>
                </li>
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="bx bxs-message"></i>
                        <span key="">Message</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('message.message-list') }}" key="">Guest Messages</a></li>
                    </ul>
                </li>
            </ul>
        </div>
        <!-- Sidebar -->
    </div>
</div>
