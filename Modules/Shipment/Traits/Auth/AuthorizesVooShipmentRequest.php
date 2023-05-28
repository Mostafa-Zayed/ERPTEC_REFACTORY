<?php 

namespace Modules\Shipment\Traits\Auth;

trait AuthorizesVooShipmentRequest
{
    public function resolveAuthorization(&$queryParams, &$formParams, &$headers)
    {
        $accessToken = $this->resolveAccessToken();
        $headers['Authorization'] = $accessToken;
    }
    
    public function resolveAccessToken()
    {
        return 'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJ1c2VySWQiOjc0NTIsInN1YiI6NzQ1MiwiaXNzIjoiaHR0cHM6Ly9teS5nZXR2b28uY29tL21lcmNoYW50cy9kZXZlbG9wZXJzL25ldyIsImlhdCI6MTY0MjA5NDkxMywiZXhwIjoxNzY4MjM4OTEzLCJuYmYiOjE2NDIwOTQ5MTMsImp0aSI6IjdYYXE5emRncGtLNHJkYVUifQ.HlCjUUkh6FbuygWF_63alooYdt39RtKOVmw-7hpaTcM';
    }
}