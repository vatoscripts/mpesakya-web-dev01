<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Session\Store;
use Illuminate\Auth\Access\AuthorizationException;

class CheckRole
{
    protected $user;
    protected $session;

    public function __construct(Store $session)
    {
        $this->user = $session->get('user');
        $this->session = $session;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, ...$role)
    {
        if (!$this->hasAnyRole($role)) {

            throw new AuthorizationException('You do not have permission to view this page');
        }

        return $next($request);
    }

    public function hasAnyRole($roles)
    {
        if (is_array($roles)) {

            foreach ($roles as $role) {
                if ($this->hasRole($role)) {
                    return TRUE;
                }
            }
        } elseif ($this->hasRole($roles)) {
            return TRUE;
        }
        return FALSE;
    }

    public function hasRole($role)
    {
        $user = $this->session->get('user');
        if ($user['Role'] == $this->getRole($role)) {
            return TRUE;
        }
        return FALSE;
    }

    public function getRole($roleID)
    {
        switch ($roleID) {
            case 'AGGREGATOR':
                return 1;
                break;
            case 'WAKALA':
                return 2;
                break;
            case 'MERCHANT':
                return 3;
                break;
            case 'TDR':
                return 4;
                break;
            case 'WAKALA_RECRUITER':
                return 5;
                break;
			case 'MPESA_ADMIN':
                return 6;
                break;
			case 'ADMIN':
                return 7;
                break;
            case 'BACKOFFICE':
                return 8;
                break;
            default:
                # code...
                break;
        }
    }
}
