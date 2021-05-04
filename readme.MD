# Бандл валидации элементов инфоблока по свойствам при сохранении для Битрикс+Symfony

## Установка

```bash
composer require proklung/bitrix-iblock-element-validator-bundle
``` 

## Принцип работы

### Валидатор

Реализует интерфейс `Prokl\BitrixIblockElementValidatorBundle\Services\Contracts\BitrixPropertyValidatorInterface`.

Методы:

- `setPropertyCode(string $code)` - символьный код валидируемого свойства
- `validate($value)` - валидация. Возвращает true, если значение OK, иначе - false
- `setErrorMessage(string $errorMessage)` - сообщение об ошибке валидации
- `setIdIblock(int $idIblock)` - ID инфоблока.

Для удобства имеется класс `Prokl\BitrixIblockElementValidatorBundle\Services\AbstractBitrixPropertyValidator`
на автомате включающий сеттеры интерфейса.

Пример валидатора:

```php
use Prokl\BitrixIblockElementValidatorBundle\Services\Exceptions\ValidateErrorException;

class ExampleCustomValidator extends AbstractBitrixPropertyValidator
{
    public function __construct(string $errorMessage)
    {
        $this->errorMessage = $errorMessage;
    }

    /**
     * @inheritDoc
     */
    public function validate($value): bool
    {
        if ($value === 'funt@mail.ru') {
            throw new ValidateErrorException(
                $this->errorMessage
            );
        }

        return true;
    }
}
```

Каждый валидатор в конфигурации контейнера помечается тэгом `bitrix_iblock_element_validator.custom_validator`.
Ключ - название сервиса.

Как-то так:

```yaml
  bitrix_iblock_element_validator.example_custom_validator:
    class: Prokl\BitrixIblockElementValidatorBundle\Services\ExampleCustomValidator
    arguments: ['Кастомная ошибка: забаненый email']
    tags:
      - { name: bitrix_iblock_element_validator.custom_validator, key: bitrix_iblock_element_validator.example_custom_validator  }
```

### Валидаторы в комплекте

- `bitrix_iblock_element_validator.unique_validator` - проверка элемента на уникальность. Не дает сохранить значение, которое уже есть в базе для заданного свойства.

## Конфигурация бандла

Файл `/local/config/packages/bitrix_iblock_element_validator.yaml`.

```yaml
bitrix_iblock_element_validator:
  enabled: true
  iblocks:
    #####################################################
    # Определение валидации свойства code_property
    # инфоблока id_iblock.
    # optional_validator - опциональный сервис валидации.
    ######################################################
    field_email_validator:
      id_iblock: 1
      sanitize: '' # Правило санации
      code_property: EMAIL
      rule: 'required|string|min:12' # Правило валидации согласно принципам Laravel Validator
      error_message: '#FIELD_NAME#: должна быть строка, не менее двенадцати символов длиной.'
      optional_validator: bitrix_iblock_element_validator.example_custom_validator

    field_phone_validator:
      id_iblock: 1
      code_property: Phone
      sanitize: ''
      rule: 'string|min:5' # Правило валидации согласно принципам Laravel Validator
      error_message: '#FIELD_NAME#: должна быть строка, не менее пяти символов длиной.'
      optional_validator: ~

    field_email_validator_unique:
      id_iblock: 1
      code_property: EMAIL
      optional_validator: bitrix_iblock_element_validator.unique_validator

    field_text_validator:
      id_iblock: 1
      code_property: TEXT
      sanitize: 'trim|escape|strip_tags|cast:string'
```