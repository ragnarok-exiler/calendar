<?php

namespace app\modules\gestion\controllers;

use app\models\User;
use app\modules\gestion\models\Festive;
use app\modules\gestion\models\Holidays;
use app\modules\gestion\models\HolidaysSearch;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;

/**
 * Default controller for the `calendario` module
 */
class CalendarioController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ]
                ]
            ]
        ];
    }

    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionSolicitud()
    {
//        $user = new User();
//        $user->username = 'mpascale';
//        $user->setPassword('test1');
//        $user->email = 'mpascale@factorenergia.com';
//        $user->generateAuthKey();
//        $user->save();

        $holidays = new Holidays();
        $holidays->user_id = 1;
        return $this->render('solicitud', ['holidays' => $holidays]);
    }

    public function actionProcessSolicitud()
    {
        $holidays = new Holidays();

        $holidays->load(Yii::$app->request->bodyParams);
        $holidays->user_id = Yii::$app->user->id;


        $festives = Festive::find()->select('free_day')->where([
            'between',
            'free_day',
            $holidays->start_date,
            $holidays->end_date
        ])->column();

        $holidaysBegin = new \DateTime($holidays->start_date);
        $holidaysEnd = new \DateTime($holidays->end_date);
        $holidaysEnd = $holidaysEnd->modify('+1 day');

        $interval = new \DateInterval('P1D');
        $holidaysRange = new \DatePeriod($holidaysBegin, $interval, $holidaysEnd);

        foreach ($holidaysRange as $holiday) {
            if (in_array($holiday->format('Y-m-d'), $festives) || $holiday->format('N') >= 6) {
                continue;
            }
            $holidays->days_number++;
        }



        if ($holidays->save()) {
            Yii::$app->session->addFlash('success', 'Días solicitados con exito.');
            return $this->redirect(['/gestion/calendario']);
        } else {
            Yii::$app->session->addFlash('error',
                'Error en la solicitud.<br>Errores generados:<br> - ' . implode('<br> - ',
                    $holidays->getErrorSummary(true)));
            return $this->redirect(['solicitud', 'holidays' => $holidays]);
        }
    }

    public function actionPeticiones()
    {
        $searchModel = new HolidaysSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->get());

        return $this->render('peticiones', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider
        ]);
    }

    public function actionPropio()
    {
        return $this->render('propio');
    }

    public function actionDepartamento()
    {

        if (empty($year = Yii::$app->request->post('year'))) {
            $year = date('Y');
        }
        return $this->render('departamento', ['year' => $year]);
    }
}
