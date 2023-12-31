        $cardNumberWW = wordwrap($card->number , 4 , '-' , true );
        dd(explode($cardNumberWW, 1));



        $cardNumber = preg_replace('/[^0-9]/', '', $card->number);
        dd($cardNumber);
        $cardNumberRev = strrev($cardNumber);
        dd($cardNumberRev);

        $cardNumberImolode = implode('-', str_split($cardNumberRev, 4));
        dd($cardNumberImolode);

        $cardNumberRev = strrev( $cardNumberImolode );
        $cardNumberFormatted = Str::of( $cardNumberImolode );
        dd($cardNumberFormatted);


        function formatCardNumber($card)
        {
            $cardNumber = preg_replace('/[^0-9]/', '', $card->number);
            $chunks = str_split($card, 4);
            $formatted = implode('-', $chunks);
            $formatted = Str::of($formatted)->trim('-');
            return $formatted;
        }
