<?php

namespace Laasti\Form;

/**
 * ElementGenerator Class
 *
 */
class ElementsGenerator
{

    public static function renderText(Field $field)
    {
        return self::renderInput($field);
    }

    public static function renderHidden(Field $field)
    {
        return self::renderInput($field);
    }

    public static function renderSearch(Field $field)
    {
        return self::renderInput($field);
    }

    public static function renderTel(Field $field)
    {
        return self::renderInput($field);
    }

    public static function renderEmail(Field $field)
    {
        return self::renderInput($field);
    }

    public static function renderPassword(Field $field)
    {
        return self::renderInput($field);
    }

    public static function renderDate(Field $field)
    {
        return self::renderInput($field);
    }

    public static function renderTime(Field $field)
    {
        return self::renderInput($field);
    }

    public static function renderNumber(Field $field)
    {
        return self::renderInput($field);
    }

    public static function renderRange(Field $field)
    {
        return self::renderInput($field);
    }

    public static function renderColor(Field $field)
    {
        return self::renderInput($field);
    }

    public static function renderCheckbox(Field $field)
    {
        if (empty($field->getChoices())) {
            return self::renderInput($field);
        }

        $html = '';
        $values = is_array($field->getValue()) ? $field->getValue() : [$field->getValue()];
        foreach ($field->getChoices() as $value => $label) {
            $checked = in_array($value, $values) ? ' checked="checked" ' : '';
            $html .= sprintf('<label><input type="checkbox" name="%s" value="%s" %s %s /> <span class="checkbox-choice-label">%s</span></label>', $field->getName(), $value, $checked, $field->getAttributes(), $label).PHP_EOL;
        }

        return self::renderInput($field);
    }

    public static function renderRadio(Field $field)
    {
        if (empty($field->getChoices())) {
            return self::renderInput($field);
        }

        $html = '';
        foreach ($field->getChoices() as $value => $label) {
            $checked = $value == $field->getValue() ? ' checked="checked" ' : '';
            $html .= sprintf('<label><input type="radio" name="%s" value="%s" %s %s /> <span class="radio-choice-label">%s</span></label>', $field->getName(), $value, $checked, $field->getAttributes(), $label).PHP_EOL;
        }

        return $html;
    }

    public static function renderFile(Field $field)
    {
        return self::renderInput($field).sprintf('<input type="hidden" name="%s" value="%s" />', $field->getName(), $field->getValue());
    }

    public static function renderSubmit(Field $field)
    {
        return self::renderButtonInput($field);
    }

    public static function renderImage(Field $field)
    {
        return self::renderInput($field);
    }

    public static function renderReset(Field $field)
    {
        return self::renderButtonInput($field);
    }

    public static function renderButton(Field $field)
    {
        return self::renderButtonInput($field);
    }

    public static function renderTextarea(Field $field)
    {
        return sprintf('<textarea name="%s" %s>%s</textarea>', $field->getName(), $field->getAttributes(), $field->getValue());
    }

    public static function renderSelect(Field $field)
    {
        if (strpos($field->getName(), '[]') || is_array($field->getValue())) {
            $field->setAttribute('multiple', 'multiple');
        }

        $selected = is_array($field->getValue()) ? $field->getValue() : [$field->getValue()];

        $select = sprintf('<select name="%s" %s>', $field->getName(), $field->getAttributes());
        foreach ($field->getChoices() as $value => $choice) {
            if (is_array($choice)) {
                if (empty($choice)) {continue;}
                $select .= sprintf('<optgroup label="%s">', $value);
                foreach ($choice as $subvalue => $subchoice) {
                    $select .= sprintf('<option value="%s" %s>%s</option>', $subvalue, in_array($subvalue, $selected) ? ' selected="selected"' : '', $subchoice);
                }
                $select .= '</optgroup>';
            } else {
                $select .= sprintf('<option value="%s" %s>%s</option>', $value, in_array($value, $selected) ? ' selected="selected"' : '', $choice);
            }
        }
        return $select.'</select>';
    }

    public static function renderOutput(Field $field)
    {
        return sprintf('<output name="%s" %s>%s</output>', $field->getName(), $field->getAttributes(), $field->getValue());
    }

    public static function renderProgress(Field $field)
    {
        return sprintf('<progress value="%s" %s>%s</progress>', $field->getValue(), $field->getAttributes(), $field->getLabel());
    }

    public static function renderMeter(Field $field)
    {
        return sprintf('<meter value="%s" %s>%s</meter>', $field->getValue(), $field->getAttributes(), $field->getLabel());
    }
    
    protected static function renderInput(Field $field)
    {
        return sprintf('<input type="%s" name="%s" value="%s" %s />', $field->getType(), $field->getName(), $field->getValue(), $field->getAttributes());
    }

    protected static function renderButtonInput(Field $field)
    {
        return sprintf('<button type="%s" name="%s" value="%s" %s>%s</button>', $field->getType(), $field->getName(), $field->getValue(), $field->getAttributes(), $field->getLabel());
    }

}
