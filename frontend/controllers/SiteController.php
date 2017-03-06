<?php
namespace frontend\controllers;

use common\actions\IAppAction;
use frontend\modules\catalogUpdater\interfaces\IModuleAction;
use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'index' => ['get'],
                    'load' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * Displays main page.
     *
     * @return mixed
     */
    public function actionIndex()
    {
	    return $this->render('index');
    }

	/**
	 * Displays Excel-file load result
	 *
	 * @return string
	 */
	public function actionLoad()
	{
		$messages = null;
		Yii::$app->getModule('catalogUpdater');

		/** @var IAppAction $action */
		$action = Yii::$container->get(IModuleAction::class);
		$action->run();

		return $this->render('result', ['status' => $action->getStatus(), 'messages' => $action->getMessages()]);
    }
}
