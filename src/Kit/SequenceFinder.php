<?php

namespace Kit;

class SequenceFinder
{
    /**
     * @param array $ar
     * @param mixed $elementToFind
     * @param int   $sequenceLength
     * @param int   $numberOfSequences
     *
     * This method finds $numberOfSequences sequences of $elementToFind in $ar that have length of $sequenceLength.
     *
     * @return array
     */
    public function findSequences(array $ar, $elementToFind, $sequenceLength, $numberOfSequences)
    {
        $sequences = [];
        $size = count($ar);
        $sequence = new Sequence(null, 0, $elementToFind);
        for ($i = 0; $i < $size; $i++) {

            if ($sequence->isEqualTo($ar[$i])) {

                if (!$sequence->isActive()) {
                    $sequence->setFrom($i);
                }
                $sequence->incrementLength();
            } else {
                if ($this->shouldAddSequence($sequence, $sequenceLength)) {
                    $sequences[] = $sequence;
                    if ($this->foundEnough($numberOfSequences, $sequences)) {
                        return $sequences;
                    }
                }

                $sequence = new Sequence(null, 0, $elementToFind);
            }
        }

        return $sequences;
    }

    /**
     * @param Sequence $sequence
     * @param int      $sequenceLength
     *
     * @return bool
     */
    private function shouldAddSequence(Sequence $sequence, $sequenceLength)
    {
        return $sequence->isActive() && $sequence->hasAtLeast($sequenceLength);
    }

    /**
     * @param int   $numberOfSequences
     * @param array $sequences
     *
     * @return bool
     */
    private function foundEnough($numberOfSequences, $sequences)
    {
        return $numberOfSequences === count($sequences);
    }
}
