<?php

namespace Modules\Cms\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Cms\Entities\CmsPage;
use Modules\Cms\Utils\CmsUtil;
use Modules\Cms\Entities\CmsSiteDetail;
use Notification;
use Modules\Cms\Notifications\NewLeadGeneratedNotification;

class CmsFeatureController extends Controller
{
    
    public function index()
    {
        dd('index');
    }
}