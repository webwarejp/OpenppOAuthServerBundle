<?php
namespace Openpp\OAuthServerBundle\Controller\Api;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;

class VerifyController extends Controller
{
    /**
     * OAuth2 認証後、ユーザー情報提供エンドポイント
     * [POST] /api/varify/client
     * @ApiDoc(
     *  description="validate client id/client secret/client token and retrive user id",
     * )
     */
    public function postClientAction(Request $request)
    {
        $token = $this->get('security.token_storage')->getToken();

        $params = array();
        $content = $request->getContent();
        if (!empty($content))
        {
            $params = json_decode($content, true); // 2nd param to get as array
        }
        $client_id = $params['client_id'];
        $client_secret = $params['client_secret'];
        $access_token = $params['access_token'];


        if(! $client_id || ! $client_secret || ! $access_token)
        {
            return ['result' => false
                , 'err' => '0'
                , 'err_msg' => 'invalid parameter'
            ];
        }

        $user = $this->findByClientAndToken($access_token, $client_id, $client_secret);
        if(! $user ) {
            return [
                'result' => false
                , 'err' => '0'
                , 'err_msg' => 'user not found'
            ];
        } else if (time() > $user['expiresAt']){
            return [
                'result' => false
                , 'err' => '0'
                , 'err_msg' => 'token expired.'
            ];
        } else {
            return [
                'result' => true
                , 'user_id' => $user['id']
                , 'expires_at' => $user['expiresAt']
            ];
        }
    }

    private function findByClientAndToken($access_token, $client_id, $client_secret)
    {
        list($id, $random_id) = explode('_', $client_id);

        if($id == null
            || $random_id == null
            || $client_secret == null)
        {
            return null;
        }

        $params = [
            'token'       => $access_token
            , 'id' => $id
            , 'random_id' => $random_id
            , 'secret'    => $client_secret
        ];

        $qb = $this->get('doctrine.orm.entity_manager')->createQueryBuilder()
            ->select('fuu.id, oat.expiresAt')
            ->from($this->getParameter('openpp_oauth_server.access_token_class') , 'oat')
            ->innerJoin('oat.client', 'oc')
            ->innerJoin('oat.user'  , 'fuu')
            ->where('oat.token       = :token')
            ->andwhere('oc.id        = :id')
            ->andWhere('oc.randomId = :random_id')
            ->andWhere('oc.secret    = :secret')
            ->setParameters($params);
        return $qb->getQuery()->getOneOrNullResult();
    }

}