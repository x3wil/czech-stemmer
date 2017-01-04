<?php declare(strict_types = 1);

namespace x3wil;

class CzechStemmer
{

    public function stemmLight(string $word): string
    {
        $word = mb_strtolower($word);
        $word = $this->removeCase($word);
        $word = $this->removePossessives($word);

        return $word;
    }

    public function stemmAgressive(string $word): string
    {
        $word = mb_strtolower($word);
        $word = $this->removeCase($word);
        $word = $this->removePossessives($word);
        $word = $this->removeComparative($word);
        $word = $this->removeDiminutive($word);
        $word = $this->removeAugmentative($word);
        $word = $this->removeDerivational($word);

        return $word;
    }

    private function removeCase(string $word): string
    {
        $length = mb_strlen($word);

        if ($length > 7 && mb_substr($word, -5) === 'atech') {
            return mb_substr($word, 0, -5);
        }

        if ($length > 6) {
            if (mb_substr($word, -4) === 'ětem') {
                $word = mb_substr($word, 0, -3);

                return $this->palatalise($word);
            }
            if (mb_substr($word, -4) === 'atům') {
                return mb_substr($word, 0, -4);
            }
        }

        if ($length > 5) {
            if (
                mb_substr($word, -3) === 'ech'
                || mb_substr($word, -3) === 'ich'
                || mb_substr($word, -3) === 'ech'
            ) {
                $word = mb_substr($word, 0, -2);

                return $this->palatalise($word);
            }

            if (
                mb_substr($word, -3) === 'ého'
                || mb_substr($word, -3) === 'ěmi'
                || mb_substr($word, -3) === 'emi'
                || mb_substr($word, -3) === 'ému'
                || mb_substr($word, -3) === 'ěte'
                || mb_substr($word, -3) === 'ěti'
                || mb_substr($word, -3) === 'iho'
                || mb_substr($word, -3) === 'ího'
                || mb_substr($word, -3) === 'ích'
                || mb_substr($word, -3) === 'ími'
                || mb_substr($word, -3) === 'imu'
            ) {
                $word = mb_substr($word, 0, -2);

                return $this->palatalise($word);
            }

            if (
                mb_substr($word, -3) === 'ách'
                || mb_substr($word, -3) === 'ata'
                || mb_substr($word, -3) === 'aty'
                || mb_substr($word, -3) === 'ých'
                || mb_substr($word, -3) === 'ama'
                || mb_substr($word, -3) === 'ami'
                || mb_substr($word, -3) === 'ové'
                || mb_substr($word, -3) === 'ovi'
                || mb_substr($word, -3) === 'ými'
            ) {
                return mb_substr($word, 0, -3);
            }
        }

        if ($length > 4) {
            if (mb_substr($word, -2) === 'em') {
                $word = mb_substr($word, 0, -1);

                return $this->palatalise($word);
            }

            if (
                mb_substr($word, -2) === 'es'
                || mb_substr($word, -2) === 'ém'
                || mb_substr($word, -2) === 'ím'
            ) {
                $word = mb_substr($word, 0, -2);

                return $this->palatalise($word);
            }

            if (mb_substr($word, -2) === 'ům') {
                return mb_substr($word, 0, -2);
            }

            if (mb_substr($word, -2) === 'at'
                || mb_substr($word, -2) === 'ám'
                || mb_substr($word, -2) === 'om'
                || mb_substr($word, -2) === 'os'
                || mb_substr($word, -2) === 'us'
                || mb_substr($word, -2) === 'ým'
                || mb_substr($word, -2) === 'mi'
                || mb_substr($word, -2) === 'ou'
            ) {
                return mb_substr($word, 0, -2);
            }
        }

        if ($length > 3) {
            if (
                mb_substr($word, -1) === 'e'
                || mb_substr($word, -1) === 'i'
            ) {
                return $this->palatalise($word);
            }
            if (
                mb_substr($word, -1) === 'í'
                || mb_substr($word, -1) === 'é'
                || mb_substr($word, -1) === 'ě'
            ) {
                return $this->palatalise($word);
            }
            if (
                mb_substr($word, -1) === 'u'
                || mb_substr($word, -1) === 'y'
                || mb_substr($word, -1) === 'ů'
            ) {
                return mb_substr($word, 0, -1);
            }
            if (mb_substr($word, -1) === 'a'
                || mb_substr($word, -1) === 'o'
                || mb_substr($word, -1) === 'á'
                || mb_substr($word, -1) === 'é'
                || mb_substr($word, -1) === 'ý'
            ) {
                return mb_substr($word, 0, -1);
            }
        }

        return $word;
    }

    private function palatalise(string $word): string
    {
        if (
            mb_substr($word, -2) === 'ci'
            || mb_substr($word, -2) === 'ce'
            || mb_substr($word, -2) === 'či'
            || mb_substr($word, -2) === 'če'
        ) {
            return mb_substr($word, 0, -2) . 'k';
        }

        if (
            mb_substr($word, -2) === 'zi'
            || mb_substr($word, -2) === 'ze'
        ) {
            return mb_substr($word, 0, -2) . 'z';
        }

        if (
            mb_substr($word, -2) === 'ži'
            || mb_substr($word, -2) === 'že'
        ) {
            return mb_substr($word, 0, -2) . 'ž';
        }

        if (
            mb_substr($word, -3) === 'čtě'
            || mb_substr($word, -3) === 'čté'
            || mb_substr($word, -3) === 'čti'
            || mb_substr($word, -3) === 'čtí'
        ) {
            return mb_substr($word, 0, -3) . 'ck';
        }

        if (
            mb_substr($word, -2) === 'ště'
            || mb_substr($word, -2) === 'šté'
            || mb_substr($word, -2) === 'šti'
            || mb_substr($word, -2) === 'ští'
        ) {
            return mb_substr($word, 0, -2) . 'sk';
        }

        return mb_substr($word, 0, -1);
    }

    private function removePossessives(string $word): string
    {
        if (mb_strlen($word) > 5) {
            if (mb_substr($word, -2) === 'ov') {
                return mb_substr($word, 0, -2);
            }

            if (mb_substr($word, -2) === 'ův') {
                return mb_substr($word, 0, -2);
            }

            if (mb_substr($word, -2) === 'in') {
                $word = mb_substr($word, 0, -1);

                return $this->palatalise($word);
            }
        }

        return $word;
    }

    private function removeDerivational(string $word)
    {
        $length = mb_strlen($word);

        if ($length > 8 && mb_substr($word, -6) === 'obinec') {
            return mb_substr($word, 0, -6);
        }

        if ($length > 7) {
            if (mb_substr($word, -5) === 'ionář') {
                $word = mb_substr($word, 0, -4);

                return $this->palatalise($word);
            }

            if (mb_substr($word, -5) === 'ovisk'
                || mb_substr($word, -5) === 'ovstv'
                || mb_substr($word, -5) === 'ovišt'
                || mb_substr($word, -5) === 'ovník'
            ) {
                return mb_substr($word, 0, -5);
            }
        }

        if ($length > 6) {
            if (mb_substr($word, -4) === 'ásek'
                || mb_substr($word, -4) === 'loun'
                || mb_substr($word, -4) === 'nost'
                || mb_substr($word, -4) === 'teln'
                || mb_substr($word, -4) === 'ovec'
                || mb_substr($word, -5) === 'ovík'
                || mb_substr($word, -4) === 'ovtv'
                || mb_substr($word, -4) === 'ovin'
                || mb_substr($word, -4) === 'štin'
            ) {
                return mb_substr($word, 0, -4);
            }
            if (mb_substr($word, -4) === 'enic'
                || mb_substr($word, -4) === 'inec'
                || mb_substr($word, -4) === 'itel'
            ) {
                $word = mb_substr($word, 0, -3);

                return $this->palatalise($word);
            }
        }

        if ($length > 5) {
            if (mb_substr($word, -3) === 'árn') {
                return mb_substr($word, 0, -3);
            }

            if (mb_substr($word, -3) === 'ěnk') {
                $word = mb_substr($word, 0, -2);

                return $this->palatalise($word);
            }

            if (mb_substr($word, -3) === 'ián'
                || mb_substr($word, -3) === 'ist'
                || mb_substr($word, -3) === 'isk'
                || mb_substr($word, -3) === 'išt'
                || mb_substr($word, -3) === 'itb'
                || mb_substr($word, -3) === 'írn'
            ) {
                $word = mb_substr($word, 0, -2);

                return $this->palatalise($word);
            }

            if (mb_substr($word, -3) === 'och'
                || mb_substr($word, -3) === 'ost'
                || mb_substr($word, -3) === 'ovn'
                || mb_substr($word, -3) === 'oun'
                || mb_substr($word, -3) === 'out'
                || mb_substr($word, -3) === 'ouš'
            ) {
                return mb_substr($word, 0, -3);
            }

            if (mb_substr($word, -3) === 'ušk') {
                return mb_substr($word, 0, -3);
            }

            if (mb_substr($word, -3) === 'kyn'
                || mb_substr($word, -3) === 'čan'
                || mb_substr($word, -3) === 'kář'
                || mb_substr($word, -3) === 'néř'
                || mb_substr($word, -3) === 'ník'
                || mb_substr($word, -3) === 'ctv'
                || mb_substr($word, -3) === 'stv'
            ) {
                return mb_substr($word, 0, -3);
            }
        }

        if ($length > 4) {
            if (mb_substr($word, -2) === 'áč'
                || mb_substr($word, -2) === 'ač'
                || mb_substr($word, -2) === 'án'
                || mb_substr($word, -2) === 'an'
                || mb_substr($word, -2) === 'ář'
                || mb_substr($word, -2) === 'as'
            ) {
                return mb_substr($word, 0, -2);
            }

            if (mb_substr($word, -2) === 'ec'
                || mb_substr($word, -2) === 'en'
                || mb_substr($word, -2) === 'ěn'
                || mb_substr($word, -2) === 'éř'
            ) {
                $word = mb_substr($word, 0, -1);

                return $this->palatalise($word);
            }

            if (mb_substr($word, -2) === 'íř'
                || mb_substr($word, -2) === 'ic'
                || mb_substr($word, -2) === 'in'
                || mb_substr($word, -2) === 'ín'
                || mb_substr($word, -2) === 'it'
                || mb_substr($word, -2) === 'iv'
            ) {
                $word = mb_substr($word, 0, -1);

                return $this->palatalise($word);
            }

            if (mb_substr($word, -2) === 'ob'
                || mb_substr($word, -2) === 'ot'
                || mb_substr($word, -2) === 'ov'
                || mb_substr($word, -2) === 'oň'
            ) {
                return mb_substr($word, 0, -2);
            }

            if (mb_substr($word, -2) === 'ul') {
                return mb_substr($word, 0, -2);
            }

            if (mb_substr($word, -2) === 'yn') {
                return mb_substr($word, 0, -2);
            }

            if (mb_substr($word, -2) === 'čk'
                || mb_substr($word, -2) === 'čn'
                || mb_substr($word, -2) === 'dl'
                || mb_substr($word, -2) === 'nk'
                || mb_substr($word, -2) === 'tv'
                || mb_substr($word, -2) === 'tk'
                || mb_substr($word, -2) === 'vk'
            ) {
                return mb_substr($word, 0, -2);
            }
        }

        if ($length > 3) {
            if (mb_substr($word, -1) === 'c'
                || mb_substr($word, -1) === 'č'
                || mb_substr($word, -1) === 'k'
                || mb_substr($word, -1) === 'l'
                || mb_substr($word, -1) === 'n'
                || mb_substr($word, -1) === 't'
            ) {
                return mb_substr($word, 0, -1);
            }
        }

        return $word;
    }

    private function removeAugmentative(string $word)
    {
        $length = mb_strlen($word);

        if ($length > 6 && mb_substr($word, -4) === 'ajzn') {
            return mb_substr($word, 0, -4);
        }

        if ($length > 5 && (mb_substr($word, -3) === 'izn' || mb_substr($word, -3) === 'isk')) {
            $word = mb_substr($word, 0, -2);

            return $this->palatalise($word);
        }

        if ($length > 4 && mb_substr($word, -2) === 'ák') {
            return mb_substr($word, 0, -2);
        }

        return $word;
    }

    private function removeDiminutive(string $word)
    {
        $length = mb_strlen($word);

        if ($length > 7 && mb_substr($word, -5) === 'oušek') {
            return mb_substr($word, 0, -5);
        }

        if ($length > 6) {
            if (mb_substr($word, -4) === 'eček'
                || mb_substr($word, -4) === 'éček'
                || mb_substr($word, -4) === 'iček'
                || mb_substr($word, -4) === 'íček'
                || mb_substr($word, -4) === 'enek'
                || mb_substr($word, -4) === 'ének'
                || mb_substr($word, -4) === 'inek'
                || mb_substr($word, -4) === 'ínek'
            ) {
                $word = mb_substr($word, 0, -3);

                return $this->palatalise($word);
            }

            if (mb_substr($word, -4) === 'áček'
                || mb_substr($word, -4) === 'aček'
                || mb_substr($word, -4) === 'oček'
                || mb_substr($word, -4) === 'uček'
                || mb_substr($word, -4) === 'anek'
                || mb_substr($word, -4) === 'onek'
                || mb_substr($word, -4) === 'unek'
                || mb_substr($word, -4) === 'ánek'
            ) {
                return mb_substr($word, 0, -4);
            }
        }

        if ($length > 5) {
            if (mb_substr($word, -3) === 'ečk'
                || mb_substr($word, -3) === 'éčk'
                || mb_substr($word, -3) === 'ičk'
                || mb_substr($word, -3) === 'íčk'
                || mb_substr($word, -3) === 'enk'
                || mb_substr($word, -3) === 'énk'
                || mb_substr($word, -3) === 'ink'
                || mb_substr($word, -3) === 'ínk'
            ) {
                $word = mb_substr($word, 0, -3);

                return $this->palatalise($word);
            }

            if (mb_substr($word, -3) === 'áčk'
                || mb_substr($word, -3) === 'ačk'
                || mb_substr($word, -3) === 'očk'
                || mb_substr($word, -3) === 'učk'
                || mb_substr($word, -3) === 'ank'
                || mb_substr($word, -3) === 'onk'
                || mb_substr($word, -3) === 'unk'
            ) {
                return mb_substr($word, 0, -3);
            }

            if (mb_substr($word, -3) === 'átk'
                || mb_substr($word, -3) === 'ánk'
                || mb_substr($word, -3) === 'ušk'
            ) {
                return mb_substr($word, 0, -3);
            }
        }

        if ($length > 4) {
            if (mb_substr($word, -2) === 'ek'
                || mb_substr($word, -2) === 'ék'
                || mb_substr($word, -2) === 'ík'
                || mb_substr($word, -2) === 'ik'
            ) {
                $word = mb_substr($word, 0, -1);

                return $this->palatalise($word);
            }

            if (mb_substr($word, -2) === 'ák'
                || mb_substr($word, -2) === 'ak'
                || mb_substr($word, -2) === 'ok'
                || mb_substr($word, -2) === 'uk'
            ) {
                return mb_substr($word, 0, -1);
            }
        }

        if ($length > 3 && mb_substr($word, -1) === 'k') {
            return mb_substr($word, 0, -1);
        }

        return $word;
    }

    private function removeComparative(string $word)
    {
        if (mb_strlen($word) > 5 && (mb_substr($word, -3) === 'ejš' || mb_substr($word, -3) === 'ějš')) {
            $word = mb_substr($word, 0, -2);

            return $this->palatalise($word);
        }

        return $word;
    }

}
