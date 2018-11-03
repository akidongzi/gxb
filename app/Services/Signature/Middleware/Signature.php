<?php 

namespace App\Services\Signature\Middleware;
use App\Exceptions\ArticleApiException as AAE;
use App\Services\Signature\SignatureService;

use Closure;

/**
 * 签名校验
 */
class Signature
{
    /**
     * 校验签名
     *
     * @param $request
     * @param Closure $next
     *
     * @return \Illuminate\Http\RedirectResponse|mixed
     */
    public function handle($request, Closure $next)
    {
        try {
            $signatureService = app()[SignatureService::class];
            if (! $signatureService->check($request)) {
                throw AAE::e(AAE::ERR_SIGNATURE_MISMATCH);
            }
        } catch (\Exception $e) {
            return response()->json([
                'errno'  => $e->getCode(),
                'errors' => [
                    'sign' => [$e->getMessage()],
                ],
            ]);
        }

        return $next($request);
    }
}
