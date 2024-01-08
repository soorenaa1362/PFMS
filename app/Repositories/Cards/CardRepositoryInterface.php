<?php

namespace App\Repositories\Cards;

interface CardRepositoryInterface
{
    public function getUserId();

    public function getCards();

    public function getTotalCash();

    public function showCard($card_id);

    public function getCardIncomes($card_id);

    public function getCardIncomeCount($card_id);

    public function getCardCosts($card_id);

    public function getCardCostCount($card_id);

    public function storeCard($request);

    public function editCard($card_id);

    public function updateCard($request, $card_id);
}

