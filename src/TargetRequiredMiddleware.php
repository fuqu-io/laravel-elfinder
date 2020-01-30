<?php

namespace Barryvdh\Elfinder;

use Closure;
use FuquIo\LaravelDisks\Helpers;
use Illuminate\Support\Facades\Storage;

class TargetRequiredMiddleware{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure                 $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next){

        if(!$request->has('target') and !$request->has('targets')){
            abort(400, 'A target directory is required');
        }

        if($request->has('target')){
            $drive_path = Helpers::finderUnHash($request->target);
            if(!Storage::disk($drive_path['drive'])->exists($drive_path['path'])){
                abort(404, 'Drive path does not exist yet.');
            }
        }

        return $next($request);
    }
}
