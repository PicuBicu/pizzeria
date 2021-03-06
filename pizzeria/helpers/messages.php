<?php
define("DATABASE_EXCEPTION", "Problem z przetwarzaniem bazy danych, spróbuj ponownie później");

define("LOGIN_CLIENT_SUCCESS", "Zalogowano pomyślnie");
define("PERMISSION_DENIED", "Brak uprawnień by zobaczyć tę stronę");
define("PAGE_NOT_FOUND", "Nie znaleziono podanej strony");

define("EMAIL_SEND_SUCCESS", "Pomyślnie wysłano potwierdzenie zamówienia na email");
define("EMAIL_SEND_ERROR", "Nie udało nam się wysłać potwierdzenia na podany email");

define("BASKET_ADD_PRODUCT_ERROR", "Wystąpił problem podczas wstawiania elementu do koszyka");
define("BASKET_ADD_PRODUCT_SUCCESS", "Pomyślnie dodano produkt do koszyka");
define("BASKET_ALREADY_HAS_THIS_PRODUCT", "Podany produkt znajduje się już w koszyku");
define("BASKET_DELETE_PRODUCT_SUCCESS", "Pomyślnie usunięto produkt z koszyka");
define("BASKET_DELETE_PRODUCT_ERROR", "Wystąpił problem podczas wstawiania elementu do koszyka");
define("BASKET_SAVE_SUCCESS", "Pomyślnie zapisano koszyk");
define("BASKET_SAVE_ERROR", "Wystąpił problem w trakcie zapisywania koszyka");
define("BASKET_EMPTY", "Koszyk jest pusty");

define("ADDRESS_SAVE_SUCCESS", "Pomyślnie dodany nowy adres dostawy");
define("ADDRESS_SAVE_ERROR", "Wystąpił problem w trakcie zapisywania adresu dostawy");
define("ADDRESS_UNABLE_TO_SELECT", "Nie posiadasz żadnego adresu");

define("ORDER_SAVE_ERROR", "Wystąpił problem w trakcie przetwarzania twojego zamówienia");
define("ORDER_SAVE_SUCCESS", "Twoje zamówienie jest w trakcie realizacji");
define("ORDER_QUANTITY_OUT_OF_RANGE", "Nie jesteśmy w stanie przetworzyć podanej ilości produktów w zamówieniu");
define("ORDER_HAS_BEEN_CANCELLED", "Anulowano zamówienie");
define("ORDER_NOT_FOUND", "Nie znaleziono szczegółów danego zamówienia");
define("ORDER_FETCH_ERROR", "Wystąpił problem w trakcie wczytywania listy zamówień");
define("ORDER_STATUS_CHANGE_ERROR", "Wystąpił problem w trakcie zmiany statusu zamówienia");
define("ORDER_STATUS_CHANGE_SUCCESS", "Pomyślnie zmieniono status zamówienia");

define("INGREDIENT_ADD_ERROR", "Wystąpił problem w trakcie dodawania składnika do bazy danych");
define("INGREDIENT_ADD_SUCCESS", "Pomyślnie dodano składnik do bazy danych");
define("INGREDIENT_UPDATE_ERROR", "Pomyślnie zaktualizowano składnik w bazie danych");
define("INGREDIENT_UPDATE_SUCCESS", "Wystąpił problem w trakcie aktualizacji składnika w bazie danych");

define("PRODUCT_ADD_ERROR", "Wystąpił problem w trakcie dodawania produktu do bazy danych");
define("PRODUCT_ADD_SUCCESS", "Pomyślnie dodano produkt do bazy danych");
define("PRODUCT_DELETE_ERROR", "Wystąpił problem w trakcie usuwania produktu z bazy danych");
define("PRODUCT_DELETE_SUCCESS", "Pomyślnie usunięto produkt do bazy danych");
define("PRODUCT_UPDATE_ERROR", "Wystąpił problem w trakcie aktualizacji produktu w bazie danych");
define("PRODUCT_UPDATE_SUCCESS", "Pomyślnie zaktualizowano produkt w bazie danych");
define("PRODUCT_NOT_FOUND", "Nie posiadamy podanego produktu");
define("PRODUCT_FETCH_ERROR", "Wystąpił problem w trakcie pobierania produktów do wyświetlenia");

define("CONTACT_DATA_SAVE_ERROR", "Wystąpił problem w trakcie dodawania danych kontaktowych");
define("CONTACT_DATA_SAVE_SUCCESS", "Pomyślnie dodano dane kontaktowe");
define("CONTACT_DATA_UNABLE_TO_SELECT", "Nie posiadasz danych kontaktowych");
