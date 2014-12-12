## Containers

#### Notes

`Notes`, called events in the system, are raised by a system user to keep a reference to something that has happened against
a `LegalEntity`, be it an incoming call, a change of attorney or something similar.

![alt note][note]

#### Warnings

`Warnings` are a special type of always visible `Note` that appear on the UI that is there to alert the system user of a special set of
circumstances surrounding that specific case.

![alt warning][warning]

#### Tasks

`Tasks` are raised when a` User` has to perform an action on an entity. These are assigned to `User` or `Team` and have a due
by date so that they can be tracked. Most tasks are generated automatically by the business rules engine.

![alt task][task]

#### Documents

`Documents` relate to physical documents that are either ingested into the system or generated by the system. Currently
we support 3 major types, being ``Incoming`` for ingested documents, ``Outgoing`` for system generated correspondence and ``Internal``
to cover reports and other types. These in essence are containers for digital copies of physical files that can be retrieved from storage.

![alt documents][documents]

#### Fees

`Fees` are currently raised against a `Deputyship` only as an annual recurring event, however the system caters for these to
be treated in an ad-hoc basis.

![alt fees][fees]

#### Payments

`Payments` are currently only raised against `PowerOfAttorney` cases and are supported by the ingestion process. These
 and `Fees` need to be further analysed and the relationship between them across all case types modelled.

![alt payments][payments]

#### Addresses

`Addresses` are a collection of `Address` entities against a person. They have an optional type so one can differentiate
what each address is used for.

![alt address][address]

#### Phone Numbers

`PhoneNumbers` are a collection of `PhoneNumber` entities against a person. They have an optional type so one can differentiate
what each phone number is used for.

![alt phonenumber][phonenumber]

[note]: ../images/note.png
[warning]: ../images/warning.png
[task]: ../images/task.png
[documents]: ../images/documents.png
[fees]: ../images/fees.png
[payments]: ../images/documents.png
[address]: ../images/address.png
[phonenumber]: ../images/phonenumber.png