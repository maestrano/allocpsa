
-- Info for the new metadata tables

INSERT INTO absenceType (absenceTypeID, absenceTypeSeq, absenceTypeActive) VALUES ('Annual Leave',1,true);
INSERT INTO absenceType (absenceTypeID, absenceTypeSeq, absenceTypeActive) VALUES ('Holiday',2,true);
INSERT INTO absenceType (absenceTypeID, absenceTypeSeq, absenceTypeActive) VALUES ('Illness',3,true);
INSERT INTO absenceType (absenceTypeID, absenceTypeSeq, absenceTypeActive) VALUES ('Other',4,true);
INSERT INTO clientStatus (clientStatusID, clientStatusSeq, clientStatusActive) VALUES ('Current',1,true);
INSERT INTO clientStatus (clientStatusID, clientStatusSeq, clientStatusActive) VALUES ('Potential',2,true);
INSERT INTO clientStatus (clientStatusID, clientStatusSeq, clientStatusActive) VALUES ('Archived',3,true);
INSERT INTO configType (configTypeID, configTypeSeq, configTypeActive) VALUES ('text',1,true);
INSERT INTO configType (configTypeID, configTypeSeq, configTypeActive) VALUES ('array',2,true);
INSERT INTO invoiceStatus (invoiceStatusID, invoiceStatusSeq, invoiceStatusActive) VALUES ('edit',1,true);
INSERT INTO invoiceStatus (invoiceStatusID, invoiceStatusSeq, invoiceStatusActive) VALUES ('reconcile',2,true);
INSERT INTO invoiceStatus (invoiceStatusID, invoiceStatusSeq, invoiceStatusActive) VALUES ('finished',3,true);
INSERT INTO itemType (itemTypeID, itemTypeSeq, itemTypeActive) VALUES ('cd',1,true);
INSERT INTO itemType (itemTypeID, itemTypeSeq, itemTypeActive) VALUES ('book',2,true);
INSERT INTO itemType (itemTypeID, itemTypeSeq, itemTypeActive) VALUES ('other',3,true);
INSERT INTO projectType (projectTypeID, projectTypeSeq, projectTypeActive) VALUES ('Project',1,true);
INSERT INTO projectType (projectTypeID, projectTypeSeq, projectTypeActive) VALUES ('Contract',2,true);
INSERT INTO projectType (projectTypeID, projectTypeSeq, projectTypeActive) VALUES ('Job',3,true);
INSERT INTO projectType (projectTypeID, projectTypeSeq, projectTypeActive) VALUES ('Prepaid',4,true);
INSERT INTO projectStatus (projectStatusID, projectStatusSeq, projectStatusActive) VALUES ('Current',1,true);
INSERT INTO projectStatus (projectStatusID, projectStatusSeq, projectStatusActive) VALUES ('Potential',2,true);
INSERT INTO projectStatus (projectStatusID, projectStatusSeq, projectStatusActive) VALUES ('Archived',3,true);
INSERT INTO roleLevel (roleLevelID, roleLevelSeq, roleLevelActive) VALUES ('person',1,true);
INSERT INTO roleLevel (roleLevelID, roleLevelSeq, roleLevelActive) VALUES ('project',2,true);
INSERT INTO reminderRecuringInterval (reminderRecuringIntervalID, reminderRecuringIntervalSeq, reminderRecuringIntervalActive) VALUES ('No',1,true);
INSERT INTO reminderRecuringInterval (reminderRecuringIntervalID, reminderRecuringIntervalSeq, reminderRecuringIntervalActive) VALUES ('Hour',2,true);
INSERT INTO reminderRecuringInterval (reminderRecuringIntervalID, reminderRecuringIntervalSeq, reminderRecuringIntervalActive) VALUES ('Day',3,true);
INSERT INTO reminderRecuringInterval (reminderRecuringIntervalID, reminderRecuringIntervalSeq, reminderRecuringIntervalActive) VALUES ('Week',4,true);
INSERT INTO reminderRecuringInterval (reminderRecuringIntervalID, reminderRecuringIntervalSeq, reminderRecuringIntervalActive) VALUES ('Month',5,true);
INSERT INTO reminderRecuringInterval (reminderRecuringIntervalID, reminderRecuringIntervalSeq, reminderRecuringIntervalActive) VALUES ('Year',6,true);
INSERT INTO reminderAdvNoticeInterval (reminderAdvNoticeIntervalID, reminderAdvNoticeIntervalSeq, reminderAdvNoticeIntervalActive) VALUES ('No',1,true);
INSERT INTO reminderAdvNoticeInterval (reminderAdvNoticeIntervalID, reminderAdvNoticeIntervalSeq, reminderAdvNoticeIntervalActive) VALUES ('Minute',2,true);
INSERT INTO reminderAdvNoticeInterval (reminderAdvNoticeIntervalID, reminderAdvNoticeIntervalSeq, reminderAdvNoticeIntervalActive) VALUES ('Hour',3,true);
INSERT INTO reminderAdvNoticeInterval (reminderAdvNoticeIntervalID, reminderAdvNoticeIntervalSeq, reminderAdvNoticeIntervalActive) VALUES ('Day',4,true);
INSERT INTO reminderAdvNoticeInterval (reminderAdvNoticeIntervalID, reminderAdvNoticeIntervalSeq, reminderAdvNoticeIntervalActive) VALUES ('Week',5,true);
INSERT INTO reminderAdvNoticeInterval (reminderAdvNoticeIntervalID, reminderAdvNoticeIntervalSeq, reminderAdvNoticeIntervalActive) VALUES ('Month',6,true);
INSERT INTO reminderAdvNoticeInterval (reminderAdvNoticeIntervalID, reminderAdvNoticeIntervalSeq, reminderAdvNoticeIntervalActive) VALUES ('Year',7,true);
INSERT INTO sentEmailType (sentEmailTypeID, sentEmailTypeSeq, sentEmailTypeActive) VALUES ('reminder',1,true);
INSERT INTO sentEmailType (sentEmailTypeID, sentEmailTypeSeq, sentEmailTypeActive) VALUES ('reminder_advnotice',2,true);
INSERT INTO sentEmailType (sentEmailTypeID, sentEmailTypeSeq, sentEmailTypeActive) VALUES ('task_created',3,true);
INSERT INTO sentEmailType (sentEmailTypeID, sentEmailTypeSeq, sentEmailTypeActive) VALUES ('task_closed',4,true);
INSERT INTO sentEmailType (sentEmailTypeID, sentEmailTypeSeq, sentEmailTypeActive) VALUES ('task_comments',5,true);
INSERT INTO sentEmailType (sentEmailTypeID, sentEmailTypeSeq, sentEmailTypeActive) VALUES ('timesheet_submit',6,true);
INSERT INTO sentEmailType (sentEmailTypeID, sentEmailTypeSeq, sentEmailTypeActive) VALUES ('timesheet_reject',7,true);
INSERT INTO sentEmailType (sentEmailTypeID, sentEmailTypeSeq, sentEmailTypeActive) VALUES ('daily_digest',8,true);
INSERT INTO sentEmailType (sentEmailTypeID, sentEmailTypeSeq, sentEmailTypeActive) VALUES ('timesheet_finished',9,true);
INSERT INTO sentEmailType (sentEmailTypeID, sentEmailTypeSeq, sentEmailTypeActive) VALUES ('new_password',10,true);
INSERT INTO sentEmailType (sentEmailTypeID, sentEmailTypeSeq, sentEmailTypeActive) VALUES ('task_reassigned',11,true);
INSERT INTO sentEmailType (sentEmailTypeID, sentEmailTypeSeq, sentEmailTypeActive) VALUES ('orphan',12,true);
INSERT INTO sentEmailType (sentEmailTypeID, sentEmailTypeSeq, sentEmailTypeActive) VALUES ('timeSheet_comments',13,true);
INSERT INTO sentEmailType (sentEmailTypeID, sentEmailTypeSeq, sentEmailTypeActive) VALUES ('project_comments',14,true);
INSERT INTO sentEmailType (sentEmailTypeID, sentEmailTypeSeq, sentEmailTypeActive) VALUES ('client_comments',15,true);
INSERT INTO sentEmailType (sentEmailTypeID, sentEmailTypeSeq, sentEmailTypeActive) VALUES ('invoice_comments',16,true);
INSERT INTO sentEmailType (sentEmailTypeID, sentEmailTypeSeq, sentEmailTypeActive) VALUES ('productSale_comments',20,true);
INSERT INTO skillProficiency (skillProficiencyID, skillProficiencySeq, skillProficiencyActive) VALUES ('Novice',1,true);
INSERT INTO skillProficiency (skillProficiencyID, skillProficiencySeq, skillProficiencyActive) VALUES ('Junior',2,true);
INSERT INTO skillProficiency (skillProficiencyID, skillProficiencySeq, skillProficiencyActive) VALUES ('Intermediate',3,true);
INSERT INTO skillProficiency (skillProficiencyID, skillProficiencySeq, skillProficiencyActive) VALUES ('Advanced',4,true);
INSERT INTO skillProficiency (skillProficiencyID, skillProficiencySeq, skillProficiencyActive) VALUES ('Senior',5,true);
INSERT INTO taskStatus (taskStatusID, taskStatusLabel, taskStatusColour, taskStatusSeq, taskStatusActive) VALUES ("open_notstarted"  ,"Open: Not Started" ,"#b0d9b0", 10,true);
INSERT INTO taskStatus (taskStatusID, taskStatusLabel, taskStatusColour, taskStatusSeq, taskStatusActive) VALUES ("open_inprogress"  ,"Open: In Progress" ,"#66f066", 20,true);
INSERT INTO taskStatus (taskStatusID, taskStatusLabel, taskStatusColour, taskStatusSeq, taskStatusActive) VALUES ("pending_info"     ,"Pending: Info"     ,"#f9ca7f", 30,true);
INSERT INTO taskStatus (taskStatusID, taskStatusLabel, taskStatusColour, taskStatusSeq, taskStatusActive) VALUES ("pending_manager"  ,"Pending: Manager"  ,"#f9ca7f", 40,true);
INSERT INTO taskStatus (taskStatusID, taskStatusLabel, taskStatusColour, taskStatusSeq, taskStatusActive) VALUES ("pending_client"   ,"Pending: Client"   ,"#f9ca7f", 50,true);
INSERT INTO taskStatus (taskStatusID, taskStatusLabel, taskStatusColour, taskStatusSeq, taskStatusActive) VALUES ("pending_tasks"    ,"Pending: Tasks"    ,"#f9ca7f", 55,true);
INSERT INTO taskStatus (taskStatusID, taskStatusLabel, taskStatusColour, taskStatusSeq, taskStatusActive) VALUES ("closed_invalid"   ,"Closed: Invalid"   ,"#e0e0e0", 60,true);
INSERT INTO taskStatus (taskStatusID, taskStatusLabel, taskStatusColour, taskStatusSeq, taskStatusActive) VALUES ("closed_duplicate" ,"Closed: Duplicate" ,"#e0e0e0", 70,true);
INSERT INTO taskStatus (taskStatusID, taskStatusLabel, taskStatusColour, taskStatusSeq, taskStatusActive) VALUES ("closed_incomplete","Closed: Incomplete","#e0e0e0", 80,true);
INSERT INTO taskStatus (taskStatusID, taskStatusLabel, taskStatusColour, taskStatusSeq, taskStatusActive) VALUES ("closed_archived"  ,"Closed: Archived"  ,"#e0e0e0", 85,true);
INSERT INTO taskStatus (taskStatusID, taskStatusLabel, taskStatusColour, taskStatusSeq, taskStatusActive) VALUES ("closed_complete"  ,"Closed: Completed" ,"#e0e0e0", 90,true);
INSERT INTO changeType (changeTypeID, changeTypeSeq, changeTypeActive) VALUES ('FieldChange',1,true);
INSERT INTO timeSheetStatus (timeSheetStatusID, timeSheetStatusSeq, timeSheetStatusActive) VALUES ('edit',1,true);
INSERT INTO timeSheetStatus (timeSheetStatusID, timeSheetStatusSeq, timeSheetStatusActive) VALUES ('manager',2,true);
INSERT INTO timeSheetStatus (timeSheetStatusID, timeSheetStatusSeq, timeSheetStatusActive) VALUES ('admin',3,true);
INSERT INTO timeSheetStatus (timeSheetStatusID, timeSheetStatusSeq, timeSheetStatusActive) VALUES ('invoiced',4,true);
INSERT INTO timeSheetStatus (timeSheetStatusID, timeSheetStatusSeq, timeSheetStatusActive) VALUES ('finished',5,true);
INSERT INTO transactionStatus (transactionStatusID, transactionStatusSeq, transactionStatusActive) VALUES ('pending',1,true);
INSERT INTO transactionStatus (transactionStatusID, transactionStatusSeq, transactionStatusActive) VALUES ('rejected',2,true);
INSERT INTO transactionStatus (transactionStatusID, transactionStatusSeq, transactionStatusActive) VALUES ('approved',3,true);
INSERT INTO transactionType (transactionTypeID, transactionTypeSeq, transactionTypeActive) VALUES ('invoice',1,true);
INSERT INTO transactionType (transactionTypeID, transactionTypeSeq, transactionTypeActive) VALUES ('expense',2,true);
INSERT INTO transactionType (transactionTypeID, transactionTypeSeq, transactionTypeActive) VALUES ('salary',3,true);
INSERT INTO transactionType (transactionTypeID, transactionTypeSeq, transactionTypeActive) VALUES ('commission',4,true);
INSERT INTO transactionType (transactionTypeID, transactionTypeSeq, transactionTypeActive) VALUES ('timesheet',5,true);
INSERT INTO transactionType (transactionTypeID, transactionTypeSeq, transactionTypeActive) VALUES ('adjustment',6,true);
INSERT INTO transactionType (transactionTypeID, transactionTypeSeq, transactionTypeActive) VALUES ('tax',8,true);
INSERT INTO transactionType (transactionTypeID, transactionTypeSeq, transactionTypeActive) VALUES ('sale',9,true);
INSERT INTO productSaleStatus (productSaleStatusID, productSaleStatusSeq, productSaleStatusActive) VALUES ('edit',1,true);
INSERT INTO productSaleStatus (productSaleStatusID, productSaleStatusSeq, productSaleStatusActive) VALUES ('allocate',2,true);
INSERT INTO productSaleStatus (productSaleStatusID, productSaleStatusSeq, productSaleStatusActive) VALUES ('admin',3,true);
INSERT INTO productSaleStatus (productSaleStatusID, productSaleStatusSeq, productSaleStatusActive) VALUES ('finished',4,true);
INSERT INTO timeSheetItemMultiplier (timeSheetItemMultiplierID, timeSheetItemMultiplierName, timeSheetItemMultiplierSeq, timeSheetItemMultiplierActive) VALUES (1.00,'Standard rate',1,true);
INSERT INTO timeSheetItemMultiplier (timeSheetItemMultiplierID, timeSheetItemMultiplierName, timeSheetItemMultiplierSeq, timeSheetItemMultiplierActive) VALUES (1.50,'Time and a half',2,true);
INSERT INTO timeSheetItemMultiplier (timeSheetItemMultiplierID, timeSheetItemMultiplierName, timeSheetItemMultiplierSeq, timeSheetItemMultiplierActive) VALUES (2.00,'Double time',3,true);
INSERT INTO timeSheetItemMultiplier (timeSheetItemMultiplierID, timeSheetItemMultiplierName, timeSheetItemMultiplierSeq, timeSheetItemMultiplierActive) VALUES (3.00,'Triple time',4,true);
INSERT INTO timeSheetItemMultiplier (timeSheetItemMultiplierID, timeSheetItemMultiplierName, timeSheetItemMultiplierSeq, timeSheetItemMultiplierActive) VALUES (0,'No charge',5,true);


-- The default active currencies
INSERT INTO currencyType (currencyTypeID,currencyTypeLabel,currencyTypeName,currencyTypeSeq,currencyTypeActive, numberToBasic) VALUES ('USD','$','United States dollar','5',true,2);
INSERT INTO currencyType (currencyTypeID,currencyTypeLabel,currencyTypeName,currencyTypeSeq,currencyTypeActive, numberToBasic) VALUES ('AUD','$','Australian dollar','10',true,2);
INSERT INTO currencyType (currencyTypeID,currencyTypeLabel,currencyTypeName,currencyTypeSeq,currencyTypeActive, numberToBasic) VALUES ('GBP','£','British pound','15',true,2);
INSERT INTO currencyType (currencyTypeID,currencyTypeLabel,currencyTypeName,currencyTypeSeq,currencyTypeActive, numberToBasic) VALUES ('CAD','$','Canadian dollar','20',true,2);
INSERT INTO currencyType (currencyTypeID,currencyTypeLabel,currencyTypeName,currencyTypeSeq,currencyTypeActive, numberToBasic) VALUES ('NZD','$','New Zealand dollar','25',true,2);
INSERT INTO currencyType (currencyTypeID,currencyTypeLabel,currencyTypeName,currencyTypeSeq,currencyTypeActive, numberToBasic) VALUES ('EUR','€','Euro','30',true,2);

-- The not-active currencies
INSERT INTO currencyType (currencyTypeID,currencyTypeLabel,currencyTypeName,currencyTypeSeq,currencyTypeActive, numberToBasic) VALUES ('AED','د.إ','United Arab Emirates dirham','11200',true,2);
INSERT INTO currencyType (currencyTypeID,currencyTypeLabel,currencyTypeName,currencyTypeSeq,currencyTypeActive, numberToBasic) VALUES ('AFN','؋','Afghan afghani','100',true,2);
INSERT INTO currencyType (currencyTypeID,currencyTypeLabel,currencyTypeName,currencyTypeSeq,currencyTypeActive, numberToBasic) VALUES ('ALL','L','Albanian lek','200',true,2);
INSERT INTO currencyType (currencyTypeID,currencyTypeLabel,currencyTypeName,currencyTypeSeq,currencyTypeActive, numberToBasic) VALUES ('AMD','դր.','Armenian dram','7350',true,2);
INSERT INTO currencyType (currencyTypeID,currencyTypeLabel,currencyTypeName,currencyTypeSeq,currencyTypeActive, numberToBasic) VALUES ('ANG','ƒ','Netherlands Antillean guilder','9600',true,2);
INSERT INTO currencyType (currencyTypeID,currencyTypeLabel,currencyTypeName,currencyTypeSeq,currencyTypeActive, numberToBasic) VALUES ('AOA','Kz','Angolan kwanza','400',true,2);
INSERT INTO currencyType (currencyTypeID,currencyTypeLabel,currencyTypeName,currencyTypeSeq,currencyTypeActive, numberToBasic) VALUES ('ARS','$','Argentine peso','550',true,2);
INSERT INTO currencyType (currencyTypeID,currencyTypeLabel,currencyTypeName,currencyTypeSeq,currencyTypeActive, numberToBasic) VALUES ('AWG','ƒ','Aruban florin','650',true,2);
INSERT INTO currencyType (currencyTypeID,currencyTypeLabel,currencyTypeName,currencyTypeSeq,currencyTypeActive, numberToBasic) VALUES ('AZN','m','Azerbaijani manat','850',true,2);
INSERT INTO currencyType (currencyTypeID,currencyTypeLabel,currencyTypeName,currencyTypeSeq,currencyTypeActive, numberToBasic) VALUES ('BAM','KM','Bosnia and Herzegovina convertible mark','1500',true,2);
INSERT INTO currencyType (currencyTypeID,currencyTypeLabel,currencyTypeName,currencyTypeSeq,currencyTypeActive, numberToBasic) VALUES ('BBD','$','Barbadian dollar','1050',true,2);
INSERT INTO currencyType (currencyTypeID,currencyTypeLabel,currencyTypeName,currencyTypeSeq,currencyTypeActive, numberToBasic) VALUES ('BDT','৳','Bangladeshi taka','1000',true,2);
INSERT INTO currencyType (currencyTypeID,currencyTypeLabel,currencyTypeName,currencyTypeSeq,currencyTypeActive, numberToBasic) VALUES ('BGN','лв','Bulgarian lev','1800',true,2);
INSERT INTO currencyType (currencyTypeID,currencyTypeLabel,currencyTypeName,currencyTypeSeq,currencyTypeActive, numberToBasic) VALUES ('BHD','.د.ب','Bahraini dinar','950',true,2);
INSERT INTO currencyType (currencyTypeID,currencyTypeLabel,currencyTypeName,currencyTypeSeq,currencyTypeActive, numberToBasic) VALUES ('BIF','Fr','Burundian franc','1950',true,2);
INSERT INTO currencyType (currencyTypeID,currencyTypeLabel,currencyTypeName,currencyTypeSeq,currencyTypeActive, numberToBasic) VALUES ('BMD','$','Bermudian dollar','1300',true,2);
INSERT INTO currencyType (currencyTypeID,currencyTypeLabel,currencyTypeName,currencyTypeSeq,currencyTypeActive, numberToBasic) VALUES ('BND','$','Brunei dollar','9500',true,2);
INSERT INTO currencyType (currencyTypeID,currencyTypeLabel,currencyTypeName,currencyTypeSeq,currencyTypeActive, numberToBasic) VALUES ('BOB','Bs.','Bolivian boliviano','1400',true,2);
INSERT INTO currencyType (currencyTypeID,currencyTypeLabel,currencyTypeName,currencyTypeSeq,currencyTypeActive, numberToBasic) VALUES ('BRL','R$','Brazilian real','1600',true,2);
INSERT INTO currencyType (currencyTypeID,currencyTypeLabel,currencyTypeName,currencyTypeSeq,currencyTypeActive, numberToBasic) VALUES ('BSD','$','Bahamian dollar','900',true,2);
INSERT INTO currencyType (currencyTypeID,currencyTypeLabel,currencyTypeName,currencyTypeSeq,currencyTypeActive, numberToBasic) VALUES ('BTN','Nu.','Bhutanese ngultrum','1350',true,2);
INSERT INTO currencyType (currencyTypeID,currencyTypeLabel,currencyTypeName,currencyTypeSeq,currencyTypeActive, numberToBasic) VALUES ('BWP','P','Botswana pula','1550',true,2);
INSERT INTO currencyType (currencyTypeID,currencyTypeLabel,currencyTypeName,currencyTypeSeq,currencyTypeActive, numberToBasic) VALUES ('BYR','Br','Belarusian ruble','1100',true,2);
INSERT INTO currencyType (currencyTypeID,currencyTypeLabel,currencyTypeName,currencyTypeSeq,currencyTypeActive, numberToBasic) VALUES ('BZD','$','Belize dollar','1200',true,2);
INSERT INTO currencyType (currencyTypeID,currencyTypeLabel,currencyTypeName,currencyTypeSeq,currencyTypeActive, numberToBasic) VALUES ('CDF','Fr','Congolese franc','2600',true,2);
INSERT INTO currencyType (currencyTypeID,currencyTypeLabel,currencyTypeName,currencyTypeSeq,currencyTypeActive, numberToBasic) VALUES ('CHF','Fr','Swiss franc','6200',true,2);
INSERT INTO currencyType (currencyTypeID,currencyTypeLabel,currencyTypeName,currencyTypeSeq,currencyTypeActive, numberToBasic) VALUES ('CLP','$','Chilean peso','2350',true,2);
INSERT INTO currencyType (currencyTypeID,currencyTypeLabel,currencyTypeName,currencyTypeSeq,currencyTypeActive, numberToBasic) VALUES ('CNY','¥','Chinese yuan','2400',true,2);
INSERT INTO currencyType (currencyTypeID,currencyTypeLabel,currencyTypeName,currencyTypeSeq,currencyTypeActive, numberToBasic) VALUES ('COP','$','Colombian peso','2500',true,2);
INSERT INTO currencyType (currencyTypeID,currencyTypeLabel,currencyTypeName,currencyTypeSeq,currencyTypeActive, numberToBasic) VALUES ('CRC','₡','Costa Rican colón','2750',true,2);
INSERT INTO currencyType (currencyTypeID,currencyTypeLabel,currencyTypeName,currencyTypeSeq,currencyTypeActive, numberToBasic) VALUES ('CUC','$','Cuban convertible peso','2900',true,2);
INSERT INTO currencyType (currencyTypeID,currencyTypeLabel,currencyTypeName,currencyTypeSeq,currencyTypeActive, numberToBasic) VALUES ('CVE','?','Cape Verdean escudo','2150',true,2);
INSERT INTO currencyType (currencyTypeID,currencyTypeLabel,currencyTypeName,currencyTypeSeq,currencyTypeActive, numberToBasic) VALUES ('CZK','Kč','Czech koruna','3050',true,2);
INSERT INTO currencyType (currencyTypeID,currencyTypeLabel,currencyTypeName,currencyTypeSeq,currencyTypeActive, numberToBasic) VALUES ('DJF','Fr','Djiboutian franc','3150',true,2);
INSERT INTO currencyType (currencyTypeID,currencyTypeLabel,currencyTypeName,currencyTypeSeq,currencyTypeActive, numberToBasic) VALUES ('DKK','kr','Danish krone','3750',true,2);
INSERT INTO currencyType (currencyTypeID,currencyTypeLabel,currencyTypeName,currencyTypeSeq,currencyTypeActive, numberToBasic) VALUES ('DOP','$','Dominican peso','3250',true,2);
INSERT INTO currencyType (currencyTypeID,currencyTypeLabel,currencyTypeName,currencyTypeSeq,currencyTypeActive, numberToBasic) VALUES ('DZD','د.ج','Algerian dinar','300',true,2);
INSERT INTO currencyType (currencyTypeID,currencyTypeLabel,currencyTypeName,currencyTypeSeq,currencyTypeActive, numberToBasic) VALUES ('EEK','kr','Estonian kroon','3600',true,2);
INSERT INTO currencyType (currencyTypeID,currencyTypeLabel,currencyTypeName,currencyTypeSeq,currencyTypeActive, numberToBasic) VALUES ('EGP','ج.م','Egyptian pound','3400',true,2);
INSERT INTO currencyType (currencyTypeID,currencyTypeLabel,currencyTypeName,currencyTypeSeq,currencyTypeActive, numberToBasic) VALUES ('ERN','Nfk','Eritrean nakfa','3550',true,2);
INSERT INTO currencyType (currencyTypeID,currencyTypeLabel,currencyTypeName,currencyTypeSeq,currencyTypeActive, numberToBasic) VALUES ('ETB','Br','Ethiopian birr','3650',true,2);
INSERT INTO currencyType (currencyTypeID,currencyTypeLabel,currencyTypeName,currencyTypeSeq,currencyTypeActive, numberToBasic) VALUES ('FJD','$','Fijian dollar','3800',true,2);
INSERT INTO currencyType (currencyTypeID,currencyTypeLabel,currencyTypeName,currencyTypeSeq,currencyTypeActive, numberToBasic) VALUES ('FKP','£','Falkland Islands pound','3700',true,2);
INSERT INTO currencyType (currencyTypeID,currencyTypeLabel,currencyTypeName,currencyTypeSeq,currencyTypeActive, numberToBasic) VALUES ('GEL','ლ','Georgian lari','4100',true,2);
INSERT INTO currencyType (currencyTypeID,currencyTypeLabel,currencyTypeName,currencyTypeSeq,currencyTypeActive, numberToBasic) VALUES ('GHS','₵','Ghanaian cedi','4200',true,2);
INSERT INTO currencyType (currencyTypeID,currencyTypeLabel,currencyTypeName,currencyTypeSeq,currencyTypeActive, numberToBasic) VALUES ('GIP','£','Gibraltar pound','4250',true,2);
INSERT INTO currencyType (currencyTypeID,currencyTypeLabel,currencyTypeName,currencyTypeSeq,currencyTypeActive, numberToBasic) VALUES ('GMD','D','Gambian dalasi','4050',true,2);
INSERT INTO currencyType (currencyTypeID,currencyTypeLabel,currencyTypeName,currencyTypeSeq,currencyTypeActive, numberToBasic) VALUES ('GNF','Fr','Guinean franc','4500',true,2);
INSERT INTO currencyType (currencyTypeID,currencyTypeLabel,currencyTypeName,currencyTypeSeq,currencyTypeActive, numberToBasic) VALUES ('GTQ','Q','Guatemalan quetzal','4400',true,2);
INSERT INTO currencyType (currencyTypeID,currencyTypeLabel,currencyTypeName,currencyTypeSeq,currencyTypeActive, numberToBasic) VALUES ('GYD','$','Guyanese dollar','4600',true,2);
INSERT INTO currencyType (currencyTypeID,currencyTypeLabel,currencyTypeName,currencyTypeSeq,currencyTypeActive, numberToBasic) VALUES ('HKD','$','Hong Kong dollar','4750',true,2);
INSERT INTO currencyType (currencyTypeID,currencyTypeLabel,currencyTypeName,currencyTypeSeq,currencyTypeActive, numberToBasic) VALUES ('HNL','L','Honduran lempira','4700',true,2);
INSERT INTO currencyType (currencyTypeID,currencyTypeLabel,currencyTypeName,currencyTypeSeq,currencyTypeActive, numberToBasic) VALUES ('HRK','kn','Croatian kuna','2850',true,2);
INSERT INTO currencyType (currencyTypeID,currencyTypeLabel,currencyTypeName,currencyTypeSeq,currencyTypeActive, numberToBasic) VALUES ('HTG','G','Haitian gourde','4650',true,2);
INSERT INTO currencyType (currencyTypeID,currencyTypeLabel,currencyTypeName,currencyTypeSeq,currencyTypeActive, numberToBasic) VALUES ('HUF','Ft','Hungarian forint','4800',true,2);
INSERT INTO currencyType (currencyTypeID,currencyTypeLabel,currencyTypeName,currencyTypeSeq,currencyTypeActive, numberToBasic) VALUES ('IDR','Rp','Indonesian rupiah','4950',true,2);
INSERT INTO currencyType (currencyTypeID,currencyTypeLabel,currencyTypeName,currencyTypeSeq,currencyTypeActive, numberToBasic) VALUES ('ILS','₪','Israeli new sheqel','8200',true,2);
INSERT INTO currencyType (currencyTypeID,currencyTypeLabel,currencyTypeName,currencyTypeSeq,currencyTypeActive, numberToBasic) VALUES ('INR','?','Indian rupee','4900',true,2);
INSERT INTO currencyType (currencyTypeID,currencyTypeLabel,currencyTypeName,currencyTypeSeq,currencyTypeActive, numberToBasic) VALUES ('IQD','ع.د','Iraqi dinar','5050',true,2);
INSERT INTO currencyType (currencyTypeID,currencyTypeLabel,currencyTypeName,currencyTypeSeq,currencyTypeActive, numberToBasic) VALUES ('IRR','﷼','Iranian rial','5000',true,2);
INSERT INTO currencyType (currencyTypeID,currencyTypeLabel,currencyTypeName,currencyTypeSeq,currencyTypeActive, numberToBasic) VALUES ('ISK','kr','Icelandic króna','4850',true,2);
INSERT INTO currencyType (currencyTypeID,currencyTypeLabel,currencyTypeName,currencyTypeSeq,currencyTypeActive, numberToBasic) VALUES ('JMD','$','Jamaican dollar','5300',true,2);
INSERT INTO currencyType (currencyTypeID,currencyTypeLabel,currencyTypeName,currencyTypeSeq,currencyTypeActive, numberToBasic) VALUES ('JOD','د.ا','Jordanian dinar','5450',true,2);
INSERT INTO currencyType (currencyTypeID,currencyTypeLabel,currencyTypeName,currencyTypeSeq,currencyTypeActive, numberToBasic) VALUES ('JPY','¥','Japanese yen','5350',true,2);
INSERT INTO currencyType (currencyTypeID,currencyTypeLabel,currencyTypeName,currencyTypeSeq,currencyTypeActive, numberToBasic) VALUES ('KES','Sh','Kenyan shilling','5550',true,2);
INSERT INTO currencyType (currencyTypeID,currencyTypeLabel,currencyTypeName,currencyTypeSeq,currencyTypeActive, numberToBasic) VALUES ('KGS','лв','Kyrgyzstani som','5850',true,2);
INSERT INTO currencyType (currencyTypeID,currencyTypeLabel,currencyTypeName,currencyTypeSeq,currencyTypeActive, numberToBasic) VALUES ('KHR','៛','Cambodian riel','2000',true,2);
INSERT INTO currencyType (currencyTypeID,currencyTypeLabel,currencyTypeName,currencyTypeSeq,currencyTypeActive, numberToBasic) VALUES ('KMF','Fr','Comorian franc','2550',true,2);
INSERT INTO currencyType (currencyTypeID,currencyTypeLabel,currencyTypeName,currencyTypeSeq,currencyTypeActive, numberToBasic) VALUES ('KPW','₩','North Korean won','5650',true,2);
INSERT INTO currencyType (currencyTypeID,currencyTypeLabel,currencyTypeName,currencyTypeSeq,currencyTypeActive, numberToBasic) VALUES ('KRW','₩','South Korean won','5700',true,2);
INSERT INTO currencyType (currencyTypeID,currencyTypeLabel,currencyTypeName,currencyTypeSeq,currencyTypeActive, numberToBasic) VALUES ('KWD','د.ك','Kuwaiti dinar','5800',true,2);
INSERT INTO currencyType (currencyTypeID,currencyTypeLabel,currencyTypeName,currencyTypeSeq,currencyTypeActive, numberToBasic) VALUES ('KYD','$','Cayman Islands dollar','2200',true,2);
INSERT INTO currencyType (currencyTypeID,currencyTypeLabel,currencyTypeName,currencyTypeSeq,currencyTypeActive, numberToBasic) VALUES ('KZT','₸','Kazakhstani tenge','5500',true,2);
INSERT INTO currencyType (currencyTypeID,currencyTypeLabel,currencyTypeName,currencyTypeSeq,currencyTypeActive, numberToBasic) VALUES ('LAK','₭','Lao kip','5900',true,2);
INSERT INTO currencyType (currencyTypeID,currencyTypeLabel,currencyTypeName,currencyTypeSeq,currencyTypeActive, numberToBasic) VALUES ('LBP','ل.ل','Lebanese pound','6000',true,2);
INSERT INTO currencyType (currencyTypeID,currencyTypeLabel,currencyTypeName,currencyTypeSeq,currencyTypeActive, numberToBasic) VALUES ('LKR','Rs','Sri Lankan rupee','10100',true,2);
INSERT INTO currencyType (currencyTypeID,currencyTypeLabel,currencyTypeName,currencyTypeSeq,currencyTypeActive, numberToBasic) VALUES ('LRD','$','Liberian dollar','6100',true,2);
INSERT INTO currencyType (currencyTypeID,currencyTypeLabel,currencyTypeName,currencyTypeSeq,currencyTypeActive, numberToBasic) VALUES ('LSL','L','Lesotho loti','6050',true,2);
INSERT INTO currencyType (currencyTypeID,currencyTypeLabel,currencyTypeName,currencyTypeSeq,currencyTypeActive, numberToBasic) VALUES ('LTL','Lt','Lithuanian litas','6250',true,2);
INSERT INTO currencyType (currencyTypeID,currencyTypeLabel,currencyTypeName,currencyTypeSeq,currencyTypeActive, numberToBasic) VALUES ('LVL','Ls','Latvian lats','5950',true,2);
INSERT INTO currencyType (currencyTypeID,currencyTypeLabel,currencyTypeName,currencyTypeSeq,currencyTypeActive, numberToBasic) VALUES ('LYD','ل.د','Libyan dinar','6150',true,2);
INSERT INTO currencyType (currencyTypeID,currencyTypeLabel,currencyTypeName,currencyTypeSeq,currencyTypeActive, numberToBasic) VALUES ('MAD','د.م.','Moroccan dirham','7250',true,2);
INSERT INTO currencyType (currencyTypeID,currencyTypeLabel,currencyTypeName,currencyTypeSeq,currencyTypeActive, numberToBasic) VALUES ('MDL','L','Moldovan leu','7000',true,2);
INSERT INTO currencyType (currencyTypeID,currencyTypeLabel,currencyTypeName,currencyTypeSeq,currencyTypeActive, numberToBasic) VALUES ('MGA','Ar','Malagasy ariary','6450',true,2);
INSERT INTO currencyType (currencyTypeID,currencyTypeLabel,currencyTypeName,currencyTypeSeq,currencyTypeActive, numberToBasic) VALUES ('MKD','ден','Macedonian denar','6400',true,2);
INSERT INTO currencyType (currencyTypeID,currencyTypeLabel,currencyTypeName,currencyTypeSeq,currencyTypeActive, numberToBasic) VALUES ('MMK','K','Myanma kyat','1900',true,2);
INSERT INTO currencyType (currencyTypeID,currencyTypeLabel,currencyTypeName,currencyTypeSeq,currencyTypeActive, numberToBasic) VALUES ('MNT','₮','Mongolian tögrög','7100',true,2);
INSERT INTO currencyType (currencyTypeID,currencyTypeLabel,currencyTypeName,currencyTypeSeq,currencyTypeActive, numberToBasic) VALUES ('MOP','P','Macanese pataca','6350',true,2);
INSERT INTO currencyType (currencyTypeID,currencyTypeLabel,currencyTypeName,currencyTypeSeq,currencyTypeActive, numberToBasic) VALUES ('MRO','UM','Mauritanian ouguiya','6800',true,2);
INSERT INTO currencyType (currencyTypeID,currencyTypeLabel,currencyTypeName,currencyTypeSeq,currencyTypeActive, numberToBasic) VALUES ('MUR','₨','Mauritian rupee','6850',true,2);
INSERT INTO currencyType (currencyTypeID,currencyTypeLabel,currencyTypeName,currencyTypeSeq,currencyTypeActive, numberToBasic) VALUES ('MVR','ރ.','Maldivian rufiyaa','6600',true,2);
INSERT INTO currencyType (currencyTypeID,currencyTypeLabel,currencyTypeName,currencyTypeSeq,currencyTypeActive, numberToBasic) VALUES ('MWK','MK','Malawian kwacha','6500',true,2);
INSERT INTO currencyType (currencyTypeID,currencyTypeLabel,currencyTypeName,currencyTypeSeq,currencyTypeActive, numberToBasic) VALUES ('MXN','$','Mexican peso','6900',true,2);
INSERT INTO currencyType (currencyTypeID,currencyTypeLabel,currencyTypeName,currencyTypeSeq,currencyTypeActive, numberToBasic) VALUES ('MYR','RM','Malaysian ringgit','6550',true,2);
INSERT INTO currencyType (currencyTypeID,currencyTypeLabel,currencyTypeName,currencyTypeSeq,currencyTypeActive, numberToBasic) VALUES ('MZN','MTn','Mozambican metical','7300',true,2);
INSERT INTO currencyType (currencyTypeID,currencyTypeLabel,currencyTypeName,currencyTypeSeq,currencyTypeActive, numberToBasic) VALUES ('NAD','$','Namibian dollar','7400',true,2);
INSERT INTO currencyType (currencyTypeID,currencyTypeLabel,currencyTypeName,currencyTypeSeq,currencyTypeActive, numberToBasic) VALUES ('NGN','₦','Nigerian naira','7800',true,2);
INSERT INTO currencyType (currencyTypeID,currencyTypeLabel,currencyTypeName,currencyTypeSeq,currencyTypeActive, numberToBasic) VALUES ('NIO','C$','Nicaraguan córdoba','7700',true,2);
INSERT INTO currencyType (currencyTypeID,currencyTypeLabel,currencyTypeName,currencyTypeSeq,currencyTypeActive, numberToBasic) VALUES ('NOK','kr','Norwegian krone','8000',true,2);
INSERT INTO currencyType (currencyTypeID,currencyTypeLabel,currencyTypeName,currencyTypeSeq,currencyTypeActive, numberToBasic) VALUES ('NPR','₨','Nepalese rupee','7500',true,2);
INSERT INTO currencyType (currencyTypeID,currencyTypeLabel,currencyTypeName,currencyTypeSeq,currencyTypeActive, numberToBasic) VALUES ('OMR','ر.ع.','Omani rial','8050',true,2);
INSERT INTO currencyType (currencyTypeID,currencyTypeLabel,currencyTypeName,currencyTypeSeq,currencyTypeActive, numberToBasic) VALUES ('PAB','B/.','Panamanian balboa','8250',true,2);
INSERT INTO currencyType (currencyTypeID,currencyTypeLabel,currencyTypeName,currencyTypeSeq,currencyTypeActive, numberToBasic) VALUES ('PEN','S/.','Peruvian nuevo sol','8400',true,2);
INSERT INTO currencyType (currencyTypeID,currencyTypeLabel,currencyTypeName,currencyTypeSeq,currencyTypeActive, numberToBasic) VALUES ('PGK','K','Papua New Guinean kina','8300',true,2);
INSERT INTO currencyType (currencyTypeID,currencyTypeLabel,currencyTypeName,currencyTypeSeq,currencyTypeActive, numberToBasic) VALUES ('PHP','₱','Philippine peso','8450',true,2);
INSERT INTO currencyType (currencyTypeID,currencyTypeLabel,currencyTypeName,currencyTypeSeq,currencyTypeActive, numberToBasic) VALUES ('PKR','₨','Pakistani rupee','8100',true,2);
INSERT INTO currencyType (currencyTypeID,currencyTypeLabel,currencyTypeName,currencyTypeSeq,currencyTypeActive, numberToBasic) VALUES ('PLN','zł','Polish złoty','8550',true,2);
INSERT INTO currencyType (currencyTypeID,currencyTypeLabel,currencyTypeName,currencyTypeSeq,currencyTypeActive, numberToBasic) VALUES ('PYG','₲','Paraguayan guaraní','8350',true,2);
INSERT INTO currencyType (currencyTypeID,currencyTypeLabel,currencyTypeName,currencyTypeSeq,currencyTypeActive, numberToBasic) VALUES ('QAR','ر.ق','Qatari riyal','8650',true,2);
INSERT INTO currencyType (currencyTypeID,currencyTypeLabel,currencyTypeName,currencyTypeSeq,currencyTypeActive, numberToBasic) VALUES ('RON','L','Romanian leu','8700',true,2);
INSERT INTO currencyType (currencyTypeID,currencyTypeLabel,currencyTypeName,currencyTypeSeq,currencyTypeActive, numberToBasic) VALUES ('RSD','дин.','Serbian dinar','9350',true,2);
INSERT INTO currencyType (currencyTypeID,currencyTypeLabel,currencyTypeName,currencyTypeSeq,currencyTypeActive, numberToBasic) VALUES ('RUB','р.','Russian ruble','10000',true,2);
INSERT INTO currencyType (currencyTypeID,currencyTypeLabel,currencyTypeName,currencyTypeSeq,currencyTypeActive, numberToBasic) VALUES ('RWF','Fr','Rwandan franc','8800',true,2);
INSERT INTO currencyType (currencyTypeID,currencyTypeLabel,currencyTypeName,currencyTypeSeq,currencyTypeActive, numberToBasic) VALUES ('SAR','ر.س','Saudi riyal','9250',true,2);
INSERT INTO currencyType (currencyTypeID,currencyTypeLabel,currencyTypeName,currencyTypeSeq,currencyTypeActive, numberToBasic) VALUES ('SBD','$','Solomon Islands dollar','9750',true,2);
INSERT INTO currencyType (currencyTypeID,currencyTypeLabel,currencyTypeName,currencyTypeSeq,currencyTypeActive, numberToBasic) VALUES ('SCR','₨','Seychellois rupee','9400',true,2);
INSERT INTO currencyType (currencyTypeID,currencyTypeLabel,currencyTypeName,currencyTypeSeq,currencyTypeActive, numberToBasic) VALUES ('SDG','£','Sudanese pound','10150',true,2);
INSERT INTO currencyType (currencyTypeID,currencyTypeLabel,currencyTypeName,currencyTypeSeq,currencyTypeActive, numberToBasic) VALUES ('SEK','kr','Swedish krona','10300',true,2);
INSERT INTO currencyType (currencyTypeID,currencyTypeLabel,currencyTypeName,currencyTypeSeq,currencyTypeActive, numberToBasic) VALUES ('SHP','£','Saint Helena pound','8900',true,2);
INSERT INTO currencyType (currencyTypeID,currencyTypeLabel,currencyTypeName,currencyTypeSeq,currencyTypeActive, numberToBasic) VALUES ('SLL','Le','Sierra Leonean leone','9450',true,2);
INSERT INTO currencyType (currencyTypeID,currencyTypeLabel,currencyTypeName,currencyTypeSeq,currencyTypeActive, numberToBasic) VALUES ('SOS','Sh','Somali shilling','9800',true,2);
INSERT INTO currencyType (currencyTypeID,currencyTypeLabel,currencyTypeName,currencyTypeSeq,currencyTypeActive, numberToBasic) VALUES ('SRD','$','Surinamese dollar','10200',true,2);
INSERT INTO currencyType (currencyTypeID,currencyTypeLabel,currencyTypeName,currencyTypeSeq,currencyTypeActive, numberToBasic) VALUES ('STD','Db','São Tomé and Príncipe dobra','9200',true,2);
INSERT INTO currencyType (currencyTypeID,currencyTypeLabel,currencyTypeName,currencyTypeSeq,currencyTypeActive, numberToBasic) VALUES ('SVC','₡','Salvadoran colón','3450',true,2);
INSERT INTO currencyType (currencyTypeID,currencyTypeLabel,currencyTypeName,currencyTypeSeq,currencyTypeActive, numberToBasic) VALUES ('SYP','ل.س','Syrian pound','10400',true,2);
INSERT INTO currencyType (currencyTypeID,currencyTypeLabel,currencyTypeName,currencyTypeSeq,currencyTypeActive, numberToBasic) VALUES ('SZL','L','Swazi lilangeni','10250',true,2);
INSERT INTO currencyType (currencyTypeID,currencyTypeLabel,currencyTypeName,currencyTypeSeq,currencyTypeActive, numberToBasic) VALUES ('THB','฿','Thai baht','10600',true,2);
INSERT INTO currencyType (currencyTypeID,currencyTypeLabel,currencyTypeName,currencyTypeSeq,currencyTypeActive, numberToBasic) VALUES ('TJS','ЅМ','Tajikistani somoni','10500',true,2);
INSERT INTO currencyType (currencyTypeID,currencyTypeLabel,currencyTypeName,currencyTypeSeq,currencyTypeActive, numberToBasic) VALUES ('TMM','m','Turkmenistani manat','10950',true,2);
INSERT INTO currencyType (currencyTypeID,currencyTypeLabel,currencyTypeName,currencyTypeSeq,currencyTypeActive, numberToBasic) VALUES ('TND','د.ت','Tunisian dinar','10850',true,2);
INSERT INTO currencyType (currencyTypeID,currencyTypeLabel,currencyTypeName,currencyTypeSeq,currencyTypeActive, numberToBasic) VALUES ('TOP','T$','Tongan paʻanga','10700',true,2);
INSERT INTO currencyType (currencyTypeID,currencyTypeLabel,currencyTypeName,currencyTypeSeq,currencyTypeActive, numberToBasic) VALUES ('TRY','₤','Turkish lira','7900',true,2);
INSERT INTO currencyType (currencyTypeID,currencyTypeLabel,currencyTypeName,currencyTypeSeq,currencyTypeActive, numberToBasic) VALUES ('TTD','$','Trinidad and Tobago dollar','10750',true,2);
INSERT INTO currencyType (currencyTypeID,currencyTypeLabel,currencyTypeName,currencyTypeSeq,currencyTypeActive, numberToBasic) VALUES ('TWD','$','New Taiwan dollar','10450',true,2);
INSERT INTO currencyType (currencyTypeID,currencyTypeLabel,currencyTypeName,currencyTypeSeq,currencyTypeActive, numberToBasic) VALUES ('TZS','Sh','Tanzanian shilling','10550',true,2);
INSERT INTO currencyType (currencyTypeID,currencyTypeLabel,currencyTypeName,currencyTypeSeq,currencyTypeActive, numberToBasic) VALUES ('UAH','₴','Ukrainian hryvnia','11150',true,2);
INSERT INTO currencyType (currencyTypeID,currencyTypeLabel,currencyTypeName,currencyTypeSeq,currencyTypeActive, numberToBasic) VALUES ('UGX','Sh','Ugandan shilling','11100',true,2);
INSERT INTO currencyType (currencyTypeID,currencyTypeLabel,currencyTypeName,currencyTypeSeq,currencyTypeActive, numberToBasic) VALUES ('UYU','$','Uruguayan peso','11350',true,2);
INSERT INTO currencyType (currencyTypeID,currencyTypeLabel,currencyTypeName,currencyTypeSeq,currencyTypeActive, numberToBasic) VALUES ('UZS','лв','Uzbekistani som','11400',true,2);
INSERT INTO currencyType (currencyTypeID,currencyTypeLabel,currencyTypeName,currencyTypeSeq,currencyTypeActive, numberToBasic) VALUES ('VEF','Bs F','Venezuelan bolívar','11550',true,2);
INSERT INTO currencyType (currencyTypeID,currencyTypeLabel,currencyTypeName,currencyTypeSeq,currencyTypeActive, numberToBasic) VALUES ('VND','₫','Vietnamese đồng','11600',true,2);
INSERT INTO currencyType (currencyTypeID,currencyTypeLabel,currencyTypeName,currencyTypeSeq,currencyTypeActive, numberToBasic) VALUES ('VUV','Vt','Vanuatu vatu','11450',true,2);
INSERT INTO currencyType (currencyTypeID,currencyTypeLabel,currencyTypeName,currencyTypeSeq,currencyTypeActive, numberToBasic) VALUES ('WST','T','Samoan tala','9100',true,2);
INSERT INTO currencyType (currencyTypeID,currencyTypeLabel,currencyTypeName,currencyTypeSeq,currencyTypeActive, numberToBasic) VALUES ('XAF','Fr','Central African CFA franc','2050',true,2);
INSERT INTO currencyType (currencyTypeID,currencyTypeLabel,currencyTypeName,currencyTypeSeq,currencyTypeActive, numberToBasic) VALUES ('XCD','$','East Caribbean dollar','9050',true,2);
INSERT INTO currencyType (currencyTypeID,currencyTypeLabel,currencyTypeName,currencyTypeSeq,currencyTypeActive, numberToBasic) VALUES ('XOF','Fr','West African CFA franc','9300',true,2);
INSERT INTO currencyType (currencyTypeID,currencyTypeLabel,currencyTypeName,currencyTypeSeq,currencyTypeActive, numberToBasic) VALUES ('XPF','Fr','CFP franc','7600',true,2);
INSERT INTO currencyType (currencyTypeID,currencyTypeLabel,currencyTypeName,currencyTypeSeq,currencyTypeActive, numberToBasic) VALUES ('YER','﷼','Yemeni rial','11750',true,2);
INSERT INTO currencyType (currencyTypeID,currencyTypeLabel,currencyTypeName,currencyTypeSeq,currencyTypeActive, numberToBasic) VALUES ('ZAR','R','South African rand','9900',true,2);
INSERT INTO currencyType (currencyTypeID,currencyTypeLabel,currencyTypeName,currencyTypeSeq,currencyTypeActive, numberToBasic) VALUES ('ZMK','ZK','Zambian kwacha','11800',true,2);


--
-- Dumping data for table permission
--
-- define("PERM_READ", 1);
-- define("PERM_UPDATE", 2);
-- define("PERM_DELETE", 4);
-- define("PERM_CREATE", 8);
-- define("PERM_READ_WRITE", PERM_READ + PERM_UPDATE + PERM_DELETE + PERM_CREATE);

DELETE FROM permission;
INSERT INTO permission (tableName, entityID, roleName, sortKey, actions, comment)
VALUES

 ('absence'                  ,-1 ,'employee' ,NULL ,1+2+4+8    ,NULL)
,('absence'                  ,0  ,'manage'   ,NULL ,1+2+4+8    ,NULL)
,('absence'                  ,0  ,'admin'    ,NULL ,1+2+4+8    ,NULL)

,('absenceType'              ,0  ,'admin'    ,NULL ,1+2+4+8    ,NULL)

,('announcement'             ,0  ,''         ,NULL ,1          ,NULL)
,('announcement'             ,0  ,'admin'    ,NULL ,1+2+4+8    ,NULL)
,('announcement'             ,0  ,'manage'   ,NULL ,1+2+4+8    ,NULL)

,('auditItem'                ,0  ,''         ,NULL ,8+1        ,'Allow all to create and read audit items.')

,('client'                   ,0  ,''         ,NULL ,1+2+4+8    ,NULL)
,('clientContact'            ,0  ,''         ,NULL ,1+2+4+8    ,NULL)

,('comment'                  ,0  ,''         ,NULL ,1+2+4+8    ,NULL)

,('commentTemplate'          ,0  ,''         ,NULL ,1          ,NULL)
,('commentTemplate'          ,0  ,'manage'   ,NULL ,1+2+4+8    ,NULL)

,('config'                   ,0  ,'god'      ,NULL ,1+2+4+8    ,NULL)

,('exchangeRate'             ,0  ,'admin'    ,NULL ,1+2+4+8    ,NULL)

,('expenseForm'              ,-1 ,'employee' ,NULL ,1+2+4+8    ,NULL)
,('expenseForm'              ,0  ,'admin'    ,NULL ,1+2+4+8    ,NULL)

,('history'                  ,0  ,''         ,NULL ,8          ,NULL)

,('inbox'                    ,0  ,'manage'   ,NULL ,1+2+4+8    ,'Manager can change inbox emails.')
,('inbox'                    ,0  ,'admin'    ,NULL ,1+2+4+8    ,'Admin can change inbox emails.')
,('inbox'                    ,0  ,'god'      ,NULL ,1+2+4+8    ,'Super-user can change inbox emails.')

,('indexQueue'               ,0  ,''         ,NULL ,1+2+4+8    ,'Allow all to indexQueue.')

,('interestedParty'          ,0  ,''         ,NULL ,11         ,'Alloc all to read, update and create.')
,('interestedParty'          ,0  ,'manage'   ,NULL ,1+2+4+8    ,NULL)
,('interestedParty'          ,0  ,'admin'    ,NULL ,1+2+4+8    ,NULL)
,('interestedParty'          ,-1 ,''         ,NULL ,1+2+4+8    ,NULL)

,('invoice'                  ,-1 ,''         ,NULL ,3          ,'Read+update invoiceItem, can change invoice.')
,('invoice'                  ,-1 ,'employee' ,NULL ,1+2+4+8    ,NULL)
,('invoice'                  ,0  ,'admin'    ,NULL ,1+2+4+8    ,NULL)

,('invoiceItem'              ,-1 ,''         ,NULL ,11         ,'Update time sheet, can change invoice item.')
,('invoiceItem'              ,-1 ,'employee' ,NULL ,1+2+4+8    ,NULL)
,('invoiceItem'              ,0  ,'admin'    ,NULL ,1+2+4+8+256,NULL)

,('invoiceRepeat'            ,0  ,'admin'    ,NULL ,1+2+4+8    ,"Admin controls repeating invoices.")
,('invoiceRepeatDate'        ,0  ,'admin'    ,NULL ,1+2+4+8    ,"Admin controls repeating invoices.")

,('item'                     ,-1 ,''         ,NULL ,1+2+4+8    ,NULL)
,('item'                     ,0  ,'employee' ,NULL ,11         ,'Read, update, create.')
,('item'                     ,0  ,'admin'    ,NULL ,1+2+4+8    ,NULL)

,('loan'                     ,0  ,'employee' ,NULL ,1+2+4+8    ,NULL)
,('loan'                     ,-1 ,'employee' ,NULL ,1+2+4+8    ,NULL)
,('loan'                     ,0  ,'admin'    ,NULL ,1+2+4+8    ,NULL)

,('permission'               ,0  ,'god'      ,NULL ,1+2+4+8    ,NULL)

,('person'                   ,-1 ,''         ,NULL ,2+256      ,NULL)
,('person'                   ,0  ,''         ,NULL ,1          ,NULL)
,('person'                   ,0  ,'manage'   ,NULL ,1+2+4+8+256+512+1024       ,NULL)
,('person'                   ,0  ,'admin'    ,NULL ,1+2+4+8+256+512+1024+2048  ,NULL)
,('person'                   ,0  ,'god'      ,NULL ,1+2+4+8+256+512+1024+2048  ,NULL)

,('product'                  ,0  ,''         ,0    ,1          ,NULL)
,('product'                  ,0  ,'manage'   ,100  ,1+2+4+8    ,NULL)
,('product'                  ,0  ,'admin'    ,100  ,1+2+4+8    ,NULL)

,('productCost'              ,0  ,''         ,NULL ,1          ,NULL)
,('productCost'              ,0  ,'manage'   ,NULL ,1+2+4+8    ,NULL)
,('productCost'              ,0  ,'admin'    ,NULL ,1+2+4+8    ,NULL)

,('productSale'              ,0  ,''         ,NULL ,1          ,NULL)
,('productSale'              ,-1 ,''         ,NULL ,1+2+4+8    ,NULL)
,('productSale'              ,0  ,'admin'    ,NULL ,1+2+4+8+256,NULL)

,('productSaleItem'          ,0  ,''         ,NULL ,1          ,NULL)
,('productSaleItem'          ,-1 ,''         ,NULL ,1+2+4+8    ,NULL)
,('productSaleItem'          ,0  ,'admin'    ,NULL ,1+2+4+8    ,NULL)

,('project'                  ,0  ,''         ,100  ,1+512      ,'Allow all to read projects for searches.')
,('project'                  ,-1 ,'employee' ,100  ,1+256+512  ,NULL)
,('project'                  ,-1 ,'employee' ,99   ,1+2+4+8+256,NULL)
,('project'                  ,-1 ,'manage'   ,100  ,1+2+4+8+256+512,NULL)
,('project'                  ,0  ,'admin'    ,100  ,1+2+4+8+256+512,NULL)

,('projectPerson'            ,-1 ,''         ,NULL ,1+2+4+8    ,NULL)
,('projectPerson'            ,-1 ,'employee' ,NULL ,1+2+4+8    ,'Allow employee PMs to add other people.')
,('projectPerson'            ,-1 ,'manage'   ,NULL ,1+2+4+8    ,NULL)
,('projectPerson'            ,0  ,'admin'    ,NULL ,1+2+4+8    ,NULL)

,('projectCommissionPerson'  ,-1 ,''         ,NULL ,1+2+4+8    ,NULL)
,('projectCommissionPerson'  ,-1 ,'manage'   ,NULL ,1+2+4+8    ,NULL)
,('projectCommissionPerson'  ,0  ,'admin'    ,NULL ,1+2+4+8    ,NULL)

,('reminder'                 ,0  ,''         ,NULL ,1+2+4+8    ,'Will have to change this later?')
,('reminderRecipient'        ,0  ,''         ,NULL ,1+2+4+8    ,NULL)

,('sentEmailLog'             ,0  ,''         ,NULL ,1+2+4+8    ,NULL)

,('skill'                    ,0  ,'employee' ,NULL ,1          ,NULL)
,('skill'                    ,0  ,'admin'    ,NULL ,1+2+4+8    ,NULL)

,('proficiency'              ,0  ,'employee' ,NULL ,1          ,NULL)
,('proficiency'              ,-1 ,'employee' ,NULL ,1+2+4+8    ,NULL)
,('proficiency'              ,0  ,'manage'   ,NULL ,1+2+4+8    ,NULL)

,('task'                     ,-1 ,'employee' ,NULL ,1+2+4+8+256,NULL)
,('task'                     ,0  ,''         ,NULL ,1          ,'Allow read all task records for searches.')
,('task'                     ,0  ,'manage'   ,NULL ,1+2+4+8+256,NULL)
,('task'                     ,0  ,'admin'    ,NULL ,1+256      ,NULL)

,('tf'                       ,0  ,'employee' ,NULL ,1          ,NULL)
,('tf'                       ,0  ,'manage'   ,NULL ,1          ,NULL)
,('tf'                       ,0  ,'admin'    ,NULL ,1+2+4+8    ,NULL)

,('tfPerson'                 ,-1 ,'employee' ,NULL ,1          ,'Allow employee to read own tfPerson.')
,('tfPerson'                 ,0  ,'admin'    ,NULL ,1+2+4+8    ,NULL)

,('timeUnit'                 ,0  ,''         ,NULL ,1          ,NULL)

,('timeSheet'                ,-1 ,'employee' ,NULL ,1+2+4+8    ,NULL)
,('timeSheet'                ,0  ,'manage'   ,NULL ,1+2+4+8+256,NULL)
,('timeSheet'                ,0  ,'admin'    ,NULL ,1+2+4+8+256+512 ,NULL)

,('timeSheetItem'            ,-1 ,''         ,NULL ,1+2+4+8    ,NULL)
,('timeSheetItem'            ,0  ,'manage'   ,NULL ,1+2+4+8    ,NULL)
,('timeSheetItem'            ,0  ,'admin'    ,NULL ,1+2+4+8    ,NULL)

,('tsiHint'                  ,0  ,'manage'   ,NULL ,1+2+4+8    ,NULL)

,('token'                    ,0  ,''         ,NULL ,1+2+4+8    ,NULL)
,('tokenAction'              ,0  ,''         ,NULL ,1          ,NULL)

,('transaction'              ,-1 ,''         ,NULL ,1+2+4+8    ,'Allow everyone to modify PENDING transactions that they own.')
,('transaction'              ,0  ,'admin'    ,NULL ,1+2+4+8    ,'Allow admin to do everything with transactions.')

,('transactionRepeat'        ,-1 ,'employee' ,NULL ,1          ,NULL)
,('transactionRepeat'        ,0  ,'admin'    ,NULL ,1+2+4+8    ,NULL)

;


--
-- Dumping data for table config
--

INSERT INTO tf (tfID,tfName,tfActive,accountTypeID) VALUES (1,"AllocPSA Main Funds",1,"REVENUE_INCOME_OTHERPRIMARYINCOME");
INSERT INTO tf (tfID,tfName,tfActive,accountTypeID) VALUES (2,"AllocPSA Incoming Funds",1,"REVENUE_INCOME_OTHERPRIMARYINCOME");
INSERT INTO tf (tfID,tfName,tfActive,accountTypeID) VALUES (3,"AllocPSA Outgoing Funds",1,"EXPENSE_EXPENSE_OTHERMISCELLANEOUSSERVICECOST");
INSERT INTO tf (tfID,tfName,tfActive,accountTypeID) VALUES (4,"AllocPSA Expense Funds",1,"EXPENSE_EXPENSE_OTHERMISCELLANEOUSSERVICECOST");
INSERT INTO tf (tfID,tfName,tfActive,accountTypeID) VALUES (5,"AllocPSA Tax Funds",1,"LIABILITY_OTHERCURRENTLIABILITY_SALESTAXPAYABLE");
INSERT INTO tf (tfID,tfName,tfActive,accountTypeID) VALUES (6,"AllocPSA My Funds",1,"REVENUE_INCOME_OTHERPRIMARYINCOME");

INSERT INTO person (personID,username,password,personActive,perms,preferred_tfID) VALUES
                   (1,'alloc','',1,'god,admin,manage,employee',6);

INSERT INTO tfPerson (tfID,personID) VALUES (6,1);

INSERT INTO config (name, value, type) VALUES ('currency', '', 'text');
INSERT INTO config (name, value, type) VALUES ('AllocFromEmailAddress','','text');
INSERT INTO config (name, value, type) VALUES ('mainTfID','1','text');
INSERT INTO config (name, value, type) VALUES ('companyName','Your Business Here','text');
INSERT INTO config (name, value, type) VALUES ('companyContactPhone','','text');
INSERT INTO config (name, value, type) VALUES ('companyContactFax','','text');
INSERT INTO config (name, value, type) VALUES ('companyContactEmail','','text');
INSERT INTO config (name, value, type) VALUES ('companyContactHomePage','','text');
INSERT INTO config (name, value, type) VALUES ('companyContactAddress','','text');
INSERT INTO config (name, value, type) VALUES ('companyACN','ACN 000 000 000','text');
INSERT INTO config (name, value, type) VALUES ('hoursInDay','7.5','text');
INSERT INTO config (name, value, type) VALUES ('companyABN','ABN 111 111 111','text');
INSERT INTO config (name, value, type) VALUES ('companyContactAddress2','','text');
INSERT INTO config (name, value, type) VALUES ('companyContactAddress3','','text');
INSERT INTO config (name, value, type) VALUES ('timeSheetPrintFooter','Authorisation (please print):<br><br>Authorisation (signature):<br><br>Date:','text');
INSERT INTO config (name, value, type) VALUES ('taxName','GST','text');
INSERT INTO config (name, value, type) VALUES ('taxPercent','10','text');
INSERT INTO config (name, value, type) VALUES ('taxTfID', '5', 'text');
INSERT INTO config (name, value, type) VALUES ('calendarFirstDay','Sun','text');
INSERT INTO config (name,value,type) VALUES ('timeSheetPrint','a:3:{i:0;s:24:"timeSheetPrintMode=items";i:1;s:24:"timeSheetPrintMode=units";i:2;s:24:"timeSheetPrintMode=money";}','array');
INSERT INTO config (name,value,type) VALUES ('timeSheetPrintOptions','a:10:{s:24:"timeSheetPrintMode=items";s:7:"Default";s:36:"timeSheetPrintMode=items&printDesc=1";s:8:"Default+";s:24:"timeSheetPrintMode=units";s:5:"Units";s:36:"timeSheetPrintMode=units&printDesc=1";s:6:"Units+";s:24:"timeSheetPrintMode=money";s:7:"Invoice";s:36:"timeSheetPrintMode=money&printDesc=1";s:8:"Invoice+";s:36:"timeSheetPrintMode=items&format=html";s:12:"Default Html";s:48:"timeSheetPrintMode=items&format=html&printDesc=1";s:13:"Default Html+";s:27:"timeSheetPrintMode=estimate";s:8:"Estimate";s:39:"timeSheetPrintMode=estimate&printDesc=1";s:9:"Estimate+";}','array'); 
INSERT INTO config (name,value,type) VALUES ('allocEmailAdmin','','text');
INSERT INTO config (name,value,type) VALUES ('allocEmailHost','','text');
INSERT INTO config (name,value,type) VALUES ('allocEmailPort','143','text');
INSERT INTO config (name,value,type) VALUES ('allocEmailUsername','','text');
INSERT INTO config (name,value,type) VALUES ('allocEmailPassword','','text');
INSERT INTO config (name,value,type) VALUES ('allocEmailProtocol','imap','text');
INSERT INTO config (name,value,type) VALUES ('allocEmailFolder','INBOX','text');
INSERT INTO config (name,value,type) VALUES ('allocEmailKeyMethod','headers','text');
INSERT INTO config (name,value,type) VALUES ('allocEmailAddressMethod','tobcc','text');
INSERT INTO config (name,value,type) VALUES ('allocEmailExtra','/notls/norsh','text');
INSERT INTO config (name,value,type) VALUES ('taskPriorities','a:5:{i:1;a:2:{s:5:"label";s:8:"Critical";s:6:"colour";s:7:"#ff0000";}i:2;a:2:{s:5:"label";s:9:"Important";s:6:"colour";s:7:"#ff7200";}i:3;a:2:{s:5:"label";s:6:"Normal";s:6:"colour";s:7:"#333333";}i:4;a:2:{s:5:"label";s:5:"Minor";s:6:"colour";s:7:"#666666";}i:5;a:2:{s:5:"label";s:8:"Wishlist";s:6:"colour";s:7:"#999999";}}','array');

INSERT INTO config (name,value,type) VALUES ('projectPriorities','a:5:{i:1;a:2:{s:5:"label";s:8:"Critical";s:6:"colour";s:7:"#ff0000";}i:2;a:2:{s:5:"label";s:9:"Important";s:6:"colour";s:7:"#ff7200";}i:3;a:2:{s:5:"label";s:6:"Normal";s:6:"colour";s:7:"#333333";}i:4;a:2:{s:5:"label";s:5:"Minor";s:6:"colour";s:7:"#666666";}i:5;a:2:{s:5:"label";s:8:"Wishlist";s:6:"colour";s:7:"#999999";}}','array');

INSERT INTO config (name,value,type) VALUES ('defaultInterestedParties','a:0:{}','array');
INSERT INTO config (name,value,type) VALUES ('inTfID','2','text');
INSERT INTO config (name,value,type) VALUES ('outTfID','3','text');
INSERT INTO config (name,value,type) VALUES ('expenseFormTfID','4','text');

INSERT INTO config (name,value,type) VALUES ('emailSubject_taskComment', '%ti %tn [%tp]', 'text');
INSERT INTO config (name,value,type) VALUES ('emailSubject_dailyDigest', 'Daily Digest', 'text');
INSERT INTO config (name,value,type) VALUES ('emailSubject_timeSheetToManager', 'Time sheet %ti submitted for your approval', 'text');
INSERT INTO config (name,value,type) VALUES ('emailSubject_timeSheetFromManager', 'Time sheet %ti rejected by manager', 'text');
INSERT INTO config (name,value,type) VALUES ('emailSubject_timeSheetFromAdministrator', 'Time sheet %ti rejected by administrator', 'text');
INSERT INTO config (name,value,type) VALUES ('emailSubject_timeSheetToAdministrator', 'Time sheet %ti submitted for your approval', 'text');
INSERT INTO config (name,value,type) VALUES ('emailSubject_timeSheetCompleted', 'Time sheet %ti completed', 'text');
INSERT INTO config (name,value,type) VALUES ('emailSubject_reminderClient', 'Client Reminder: %li %cc', 'text');
INSERT INTO config (name,value,type) VALUES ('emailSubject_reminderProject', 'Project Reminder: %pi %pn', 'text');
INSERT INTO config (name,value,type) VALUES ('emailSubject_reminderTask', 'Task Reminder: %ti %tn [%tp]', 'text');
INSERT INTO config (name,value,type) VALUES ('emailSubject_reminderOther', 'Reminder: ', 'text');
INSERT INTO config (name,value,type) VALUES ('wikiMarkup', 'Markdown','text');
INSERT INTO config (name,value,type) VALUES ('wikiVCS', 'git','text');
INSERT INTO config (name,value,type) VALUES ('singleSession','1','text');
INSERT INTO config (name, value, type) VALUES ('clientCategories','a:7:{i:0;a:2:{s:5:"label";s:6:"Client";s:5:"value";i:1;}i:1;a:2:{s:5:"label";s:6:"Supplier";s:5:"value";i:2;}i:2;a:2:{s:5:"label";s:8:"Supplier";s:5:"value";i:3;}i:3;a:2:{s:5:"label";s:10:"Consultant";s:5:"value";i:4;}i:4;a:2:{s:5:"label";s:10:"Government";s:5:"value";i:5;}i:5;a:2:{s:5:"label";s:10:"Non-profit";s:5:"value";i:6;}i:6;a:2:{s:5:"label";s:8:"Internal";s:5:"value";i:7;}}','array');
INSERT INTO config (name,value,type) VALUES ('defaultTimeSheetManagerList', 'a:0:{}', 'array');
INSERT INTO config (name,value,type) VALUES ('defaultTimeSheetAdminList', 'a:0:{}', 'array');
INSERT INTO config (name,value,type) VALUES ('allocSessionMinutes', '540', 'text');
INSERT INTO config (name,value,type) VALUES ('defaultTimeSheetRate', '', 'text');
INSERT INTO config (name,value,type) VALUES ('defaultTimeSheetUnit', 1, 'text'); -- ref timeUnit below
INSERT INTO config (name,value,type) VALUES ('mapURL', 'http://maps.google.com/?q=%ad', 'text');
INSERT INTO config (name,value,type) VALUES ('rssStatusFilter', 'a:7:{i:0;s:12:"pending_info";i:1;s:15:"pending_manager";i:2;s:14:"pending_client";i:3;s:14:"closed_invalid";i:4;s:16:"closed_duplicate";i:5;s:17:"closed_incomplete";i:6;s:15:"closed_complete";}', 'array');
INSERT INTO config (name,value,type) VALUES ('rssEntries', '20', 'text');
INSERT INTO config (name,value,type) VALUES ('rssShowProject', 'on', 'text');
INSERT INTO config (name,value,type) VALUES ('allocTabs','a:11:{i:0;s:4:"home";i:1;s:6:"client";i:2;s:7:"project";i:3;s:4:"task";i:4;s:4:"time";i:5;s:7:"invoice";i:6;s:4:"sale";i:7;s:6:"person";i:8;s:4:"wiki";i:9;s:5:"inbox";i:10;s:5:"tools";}','array');
INSERT INTO config (name,value,type) VALUES ('allocURL','','text');
INSERT INTO config (name,value,type) VALUES ('allocTimezone','','text');
INSERT INTO config (name,value,type) VALUES ("taskPrioritySpread","20","text");
INSERT INTO config (name,value,type) VALUES ("taskPriorityScale","8","text");

--
-- Dumping data for table taskType
--


INSERT INTO taskType (taskTypeID, taskTypeSeq, taskTypeActive) VALUES ('Task'     ,10,true);
INSERT INTO taskType (taskTypeID, taskTypeSeq, taskTypeActive) VALUES ('Parent'   ,20,true);
INSERT INTO taskType (taskTypeID, taskTypeSeq, taskTypeActive) VALUES ('Message'  ,30,true);
INSERT INTO taskType (taskTypeID, taskTypeSeq, taskTypeActive) VALUES ('Fault'    ,40,true);
INSERT INTO taskType (taskTypeID, taskTypeSeq, taskTypeActive) VALUES ('Milestone',50,true);

--
-- Dumping data for table timeUnit
--


INSERT INTO timeUnit (timeUnitID, timeUnitName, timeUnitLabelA, timeUnitLabelB, timeUnitSeconds, timeUnitActive, timeUnitSequence) VALUES (1,'hour','Hours','Hourly',3600,true,10);
INSERT INTO timeUnit (timeUnitID, timeUnitName, timeUnitLabelA, timeUnitLabelB, timeUnitSeconds, timeUnitActive, timeUnitSequence) VALUES (2,'day','Days','Daily',27000,true,20);
INSERT INTO timeUnit (timeUnitID, timeUnitName, timeUnitLabelA, timeUnitLabelB, timeUnitSeconds, timeUnitActive, timeUnitSequence) VALUES (3,'week','Weeks','Weekly',135000,true,30);
INSERT INTO timeUnit (timeUnitID, timeUnitName, timeUnitLabelA, timeUnitLabelB, timeUnitSeconds, timeUnitActive, timeUnitSequence) VALUES (4,'month','Months','Monthly',540000,true,40);
INSERT INTO timeUnit (timeUnitID, timeUnitName, timeUnitLabelA, timeUnitLabelB, timeUnitSeconds, timeUnitActive, timeUnitSequence) VALUES (5,'fixed','Fixed Rate','Fixed Rate',0,true,50);

--
-- Dumping data for table role
--


INSERT INTO role (roleID, roleName, roleHandle, roleLevel, roleSequence) VALUES (1,'Manage project','isManager', 'project', 30);
INSERT INTO role (roleID, roleName, roleHandle, roleLevel, roleSequence) VALUES (2,'Edit tasks','canEditTasks', 'project', 20);
INSERT INTO role (roleID, roleName, roleHandle, roleLevel, roleSequence) VALUES (3,'Approve time sheets','timeSheetRecipient', 'project', 40);
INSERT INTO role (roleID, roleName, roleHandle, roleLevel, roleSequence) VALUES (4,'Super User','god', 'person', 10);
INSERT INTO role (roleID, roleName, roleHandle, roleLevel, roleSequence) VALUES (5,'Finance Admin','admin', 'person', 20);
INSERT INTO role (roleID, roleName, roleHandle, roleLevel, roleSequence) VALUES (6,'Project Manager','manage', 'person', 30);
INSERT INTO role (roleID, roleName, roleHandle, roleLevel, roleSequence) VALUES (7,'Employee','employee','person', 40);

-- Has to be tokenActionID of 2 for reverse compatibility 
INSERT INTO tokenAction (tokenActionID,tokenAction,tokenActionType,tokenActionMethod) VALUES (2,'Add Comments to Comment','comment','add_comment_from_email');
INSERT INTO tokenAction (tokenActionID,tokenAction,tokenActionType,tokenActionMethod) VALUES (3,'Task status move pending to open','task','moved_from_pending_to_open');
INSERT INTO tokenAction (tokenActionID,tokenAction,tokenActionType,tokenActionMethod) VALUES (4,'Reopen pending task','task','reopen_pending_task');
