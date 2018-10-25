<?php namespace Zizaco\Entrust\Middleware;

/**
 * This file is part of Entrust,
 * a role & permission management solution for Laravel.
 *
 * @license MIT
 * @package Zizaco\Entrust
 */

use Closure;
use Illuminate\Contracts\Auth\Guard;

class EntrustRole
{
	const DELIMITER = '|';

	protected $auth;

	/**
	 * Creates a new instance of the middleware.
	 *
	 * @param Guard $auth
	 */
	public function __construct(Guard $auth)
	{
		$this->auth = $auth;
	}

	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @param  Closure $next
	 * @param  $roles
	 * @return mixed
	 */
	public function handle($request, Closure $next, $roles)
	{
		if (!is_array($roles)) {
			$roles = explode(self::DELIMITER, $roles);
		}

		if ($this->auth->guest() || !$request->user()->hasRole($roles)) {
<<<<<<< HEAD
			abort(403);
=======
			return \Redirect::to('/')->with('message', 'El usuario no cuenta con los permisos requeridos.')
                    ->withInput();
>>>>>>> 5c172ba75039de0f7e8e840a073bcf741fe3205e
		}

		return $next($request);
	}
}
