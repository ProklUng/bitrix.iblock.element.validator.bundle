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