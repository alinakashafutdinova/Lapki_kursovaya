<?php

namespace MyProject\Controllers;

class CalculatorController extends AbstractController
{
    /**
     * Калькулятор суточной нормы корма.
     * Расчёт данных на основе параметров (вес, вид, возраст, активность).
     * Параметры приходят GET-запросом, результат считается на сервере (PHP).
     */
    public function feed(): void
    {
        $result = null;
        $params = [
            'weight'   => $_GET['weight']   ?? '',
            'species'  => $_GET['species']  ?? 'cat',
            'age'      => $_GET['age']      ?? 'adult',
            'activity' => $_GET['activity'] ?? 'normal',
        ];

        // Если переданы корректные параметры — выполняем расчёт
        if (isset($_GET['weight']) && is_numeric($_GET['weight']) && (float) $_GET['weight'] > 0) {
            $weight   = (float) $_GET['weight'];
            $species  = in_array($params['species'], ['cat', 'dog'], true) ? $params['species'] : 'cat';
            $age      = in_array($params['age'], ['baby', 'adult', 'senior'], true) ? $params['age'] : 'adult';
            $activity = in_array($params['activity'], ['low', 'normal', 'high'], true) ? $params['activity'] : 'normal';

            // Базовая норма: г сухого корма на кг веса
            $basePerKg = $species === 'cat' ? 20 : 25;

            // Коэффициент возраста
            $ageFactor = ['baby' => 1.6, 'adult' => 1.0, 'senior' => 0.85][$age];
            // Коэффициент активности
            $activityFactor = ['low' => 0.9, 'normal' => 1.0, 'high' => 1.2][$activity];

            $gramsPerDay = $weight * $basePerKg * $ageFactor * $activityFactor;
            $gramsPerDay = (int) round($gramsPerDay);

            // Примерные калории: ~3.5 ккал на грамм сухого корма
            $kcalPerDay = (int) round($gramsPerDay * 3.5);

            // Рекомендуемое число кормлений
            $meals = $age === 'baby' ? 4 : ($age === 'senior' ? 2 : 3);

            $result = [
                'grams'      => $gramsPerDay,
                'kcal'       => $kcalPerDay,
                'meals'      => $meals,
                'gramsPerMeal' => (int) round($gramsPerDay / $meals),
            ];
        }

        $this->render('calculator/feed.php', [
            'title'  => 'Калькулятор корма — Лапки',
            'params' => $params,
            'result' => $result,
        ]);
    }
}
