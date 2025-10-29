<?php

namespace Amx\Salesforce\Traits\Standard;

trait SFAccountFields
{
    public ?string $Id = null;

    /** Master Record ID */
    public ?string $MasterRecordId = null;

    /** Account Name */
    public ?string $Name = null;

    /** Account Type */
    public ?string $Type = null;

    /** Record Type ID */
    public ?string $RecordTypeId = null;

    /** Parent Account ID */
    public ?string $ParentId = null;

    /** Billing Street */
    public ?string $BillingStreet = null;

    /** Billing City */
    public ?string $BillingCity = null;

    /** Billing State/Province */
    public ?string $BillingState = null;

    /** Billing Zip/Postal Code */
    public ?string $BillingPostalCode = null;

    /** Billing Country */
    public ?string $BillingCountry = null;

    /** Billing Latitude */
    public ?float $BillingLatitude = null;

    /** Billing Longitude */
    public ?float $BillingLongitude = null;

    /** Billing Geocode Accuracy */
    public ?string $BillingGeocodeAccuracy = null;

    /** Billing Address */
    public ?string $BillingAddress = null;

    /** Shipping Street */
    public ?string $ShippingStreet = null;

    /** Shipping City */
    public ?string $ShippingCity = null;

    /** Shipping State/Province */
    public ?string $ShippingState = null;

    /** Shipping Zip/Postal Code */
    public ?string $ShippingPostalCode = null;

    /** Shipping Country */
    public ?string $ShippingCountry = null;

    /** Shipping Latitude */
    public ?float $ShippingLatitude = null;

    /** Shipping Longitude */
    public ?float $ShippingLongitude = null;

    /** Shipping Geocode Accuracy */
    public ?string $ShippingGeocodeAccuracy = null;

    /** Shipping Address */
    public ?string $ShippingAddress = null;

    /** Account Phone */
    public ?string $Phone = null;

    /** Account Fax */
    public ?string $Fax = null;

    /** Account Number */
    public ?string $AccountNumber = null;

    /** Website */
    public ?string $Website = null;

    /** Photo URL */
    public ?string $PhotoUrl = null;

    /** SIC Code */
    public ?string $Sic = null;

    /** Industry */
    public ?string $Industry = null;

    /** Annual Revenue */
    public ?float $AnnualRevenue = null;

    /** Employees */
    public ?int $NumberOfEmployees = null;

    /** Ownership */
    public ?string $Ownership = null;

    /** Ticker Symbol */
    public ?string $TickerSymbol = null;

    /** Account Description */
    public ?string $Description = null;

    /** Account Rating */
    public ?string $Rating = null;

    /** Account Site */
    public ?string $Site = null;

    /** Last Activity */
    public ?string $LastActivityDate = null;

    /** Last Viewed Date */
    public ?string $LastViewedDate = null;

    /** Last Referenced Date */
    public ?string $LastReferencedDate = null;

    /** Account Source */
    public ?string $AccountSource = null;

    /** SIC Description */
    public ?string $SicDesc = null;

    /** Received Connection ID */
    public ?string $ConnectionReceivedId = null;

    /** Sent Connection ID */
    public ?string $ConnectionSentId = null;

    /** Aviso/Warning */
    public ?string $Aviso__c = null;

    /** airline */
    public ?string $Logo__c = null;

    /** Acc Type 2017 */
    public ?string $Acc_Type_2017__c = null;

    /** Acc Type 2018 */
    public ?string $Acc_Type_2018__c = null;

    /** Account Type Gral. 2015 */
    public ?string $Account_Type_Gral_2015__c = null;

    /** Account Type Gral. 2016 */
    public ?string $Account_Type_Gral_2016__c = null;

    /** Account Type Gral. 2017 */
    public ?string $Account_Type_Gral_2017__c = null;

    /** Account Type Gral. 2018 */
    public ?string $Account_Type_Gral_2018__c = null;

    /** Account Type Gral. 2019 */
    public ?string $Account_Type_Gral_2019__c = null;

    /** Measurement 2017 */
    public ?string $Measurement_2017__c = null;

    /** Measurement 2018 */
    public ?string $Measurement_2018__c = null;

    /** Sales Director */
    public ?string $Sales_Director__c = null;

    /** # CPC */
    public ?string $CPC__c = null;

    /** BCC */
    public ?string $BCC__c = null;

    /** CORP ID */
    public ?string $CORP_ID__c = null;

    /** Rank 100 */
    public ?string $Rank_100__c = null;

    /** TD (Historico) */
    public ?string $TD_Historico__c = null;

    /** Authorized Lounge */
    public ?string $Authorized_Card_Classic__c = null;

    /** Authorized Card Gold */
    public ?string $Authorized_Card_Gold__c = null;

    /** Authorized Card Platino */
    public ?string $Authorized_Card_Platino__c = null;

    /** Used Lounge */
    public ?string $Used_Card_Classic__c = null;

    /** Used Card Gold */
    public ?string $Used_Card_Gold__c = null;

    /** Used Card Platino */
    public ?string $Used_Card_Platino__c = null;

    /** Firma de Convenio */
    public ?string $Firma_de_Convenio__c = null;

    /** Contract Value Currency */
    public ?string $Contract_Value_Currency__c = null;

    /** New or Renovation 2017 */
    public ?string $New_or_Renovation_2017__c = null;

    /** New or Renovation 2018 */
    public ?string $New_or_Renovation_2018__c = null;

    /** New or Renovation 2019 */
    public ?string $New_or_Renovation_2019__c = null;

    /** Authorized Name */
    public ?string $Authorized_Name__c = null;

    /** Corporate Sales Development */
    public ?string $CSD__c = null;

    /** Company ID */
    public ?string $Company_ID__c = null;

    /** Continent */
    public ?string $Continente__c = null;

    /** Corporate o Group */
    public ?string $Corporativo_o_Grupo__c = null;

    /** Estatus de la cuenta */
    public ?string $Estatus_de_la_cuenta__c = null;

    /** Industry type */
    public ?string $Giro__c = null;

    /** IATA 7 */
    public ?string $IATA_7__c = null;

    /** HOME IATA/ ARC */
    public ?string $IATA_ARC__c = null;

    /** Id Origen */
    public ?string $Id_Origen__c = null;

    /** Level */
    public ?string $Level__c = null;

    /** Management */
    public ?string $Management__c = null;

    /** Measurement */
    public ?string $Medici_n__c = null;

    /** PARENT SPID */
    public ?string $PARENT_SPID__c = null;

    /** PRISM ID */
    public ?string $PRISM_ID__c = null;

    /** Point of Sale */
    public ?string $Punto_Vnta__c = null;

    /** Q1 */
    public ?string $Q1__c = null;

    /** RFC-TIN-NIP-RUC */
    public ?string $RFC__c = null;

    /** Region */
    public ?string $Region__c = null;

    /** Resumen de ejecutivo */
    public ?string $Resumen_Ejecutivo__c = null;

    /** Sales Channel */
    public ?string $SALES_CHANNEL__c = null;

    /** SPID */
    public ?string $SPID__c = null;

    /** Segment */
    public ?string $Segmento__c = null;

    /** State */
    public ?string $State__c = null;

    /** Sub channel */
    public ?string $Sub_channel__c = null;

    /** Sub group */
    public ?string $Sub_grupo__c = null;

    /** Ticket Designator */
    public ?string $Ticket_Designator__c = null;

    /** Account Type 2022 */
    public ?string $Tipo_de_cuenta__c = null;

    /** Tour Code */
    public ?string $Tour_Code__c = null;

    /** Benefit */
    public ?string $Benefit__c = null;

    /** Value Contract MXN */
    public ?float $Value_Contract_MXN__c = null;

    /** Contract Value Rev */
    public ?float $Contract_Value_Rev__c = null;

    /** AST_IHome8 */
    public ?float $AST_IHome8__c = null;

    /** AST_Manage */
    public ?string $AST_Manage__c = null;

    /** Estatus del Prospecto */
    public ?string $Estatus_del_Prospecto__c = null;

    /** Tipo de Prospección */
    public ?string $Tipo_de_Prospeccion__c = null;

    /** AST_IATA8 */
    public ?float $AST_IATA8__c = null;

    /** ASD Leader */
    public ?string $ASD_Leader__c = null;

    /** IATA */
    public ?string $Branches__c = null;

    /** C.P. */
    public ?float $C_P__c = null;

    /** Canal */
    public ?string $Canal__c = null;

    /** Ciudad */
    public ?string $Ciudad__c = null;

    /** Clasificación ASD */
    public ?string $Clasificacion_ASD__c = null;

    /** Dirección Fiscal */
    public ?string $Direccion_Fiscal__c = null;

    /** Dirección Visitas */
    public ?string $Direccion_Visitas__c = null;

    /** Distrito */
    public ?string $Distrito__c = null;

    /** New o Renovation 2020 */
    public ?string $New_or_Renovation_2020__c = null;

    /** JCA Account Manager */
    public ?string $mngr_JCA__c = null;

    /** Estado/Provincia */
    public ?string $Estado_Provincia__c = null;

    /** Familia */
    public ?string $Familia__c = null;

    /** GDS */
    public ?string $GDS__c = null;

    /** Regional Manager */
    public ?string $mngr_regional1__c = null;

    /** Grupo ASD */
    public ?string $Grupo_ASD__c = null;

    /** Nombre Comercial */
    public ?string $Nombre_Comercial__c = null;

    /** Nombre Legal */
    public ?string $Nombre_Legal__c = null;

    /** País */
    public ?string $Pais__c = null;

    /** Ranking */
    public ?string $Ranking__c = null;

    /** Legal signee */
    public ?string $Agency_legal_signee1__c = null;

    /** Segmentation */
    public ?string $Segmentacion__c = null;

    /** Zona */
    public ?string $Zona__c = null;

    /** IVR Code */
    public ?string $IVR_Code__c = null;

    /** Fecha firma A-1 */
    public ?string $Fecha_firma_A_1__c = null;

    /** Clave Pos */
    public ?string $Punto_de_VentaCPS__c = null;

    /** Ancilaries Disponible Q1 */
    public ?float $Ancilaries_Disponible_Q1__c = null;

    /** Budget */
    public ?string $Budget__c = null;

    /** Contract Folio */
    public ?string $Contract_Folio_home__c = null;

    /** Contract 2020 */
    public ?string $ContractFolio_2020_N2__c = null;

    /** Q2 */
    public ?string $Q2__c = null;

    /** Last Reported Activity */
    public ?string $DDS_Last_Activity__c = null;

    /** Gss Id */
    public ?string $Gss_Id__c = null;

    /** Id Presupuesto */
    public ?string $Id_Presupuesto__c = null;

    /** Presupuesto */
    public ?string $Presupuesto__c = null;

    /** Total Disponible Corporativo */
    public ?float $Presupuesto_disponible__c = null;

    /** DDS Agency Name */
    public ?string $DDS_Agency_Name__c = null;

    /** DDS Trade Name */
    public ?string $DDS_Trade_Name__c = null;

    /** Home Office Number */
    public ?string $DDS_Home__c = null;

    /** Global Region */
    public ?string $DDS_Global_Region__c = null;

    /** ASTMerge19 */
    public ?string $ASTMerge19__c = null;

    /** Account Type Gral. 2020 */
    public ?string $Account_Type_Gral_2020__c = null;

    /** Measurement 2020 */
    public ?string $Measurement_2020__c = null;

    /** Account Type 2019 */
    public ?string $Account_Type_2019__c = null;

    /** Tipo de Cliente */
    public ?string $Tipo_de_Cliente__c = null;

    /** Comunicado GSS */
    public ?string $Comunicado_GSS__c = null;

    /** Gss ID */
    public ?string $Gss_Id_edit__c = null;

    /** DDS Country */
    public ?string $DDS_Country__c = null;

    /** Gss ID Corp */
    public ?string $Gss_ID_Corp__c = null;

    /** DDS_State */
    public ?string $DDS_State__c = null;

    /** DDS_City */
    public ?string $DDS_City__c = null;

    /** Street Address */
    public ?string $DDS_Street_Address__c = null;

    /** Postal Code */
    public ?string $DDS_Postal_Code__c = null;

    /** Ejecutivo 2 */
    public ?string $agy_Ejecutivo_2__c = null;

    /** Account Manager [2] */
    public ?string $mngr_account2__c = null;

    /** Account Manager [3] */
    public ?string $mngr_account3__c = null;

    /** Account Manager [4] */
    public ?string $mngr_account4__c = null;

    /** Regional Manager [2] */
    public ?string $mngr_regional2__c = null;

    /** District Manager [1] */
    public ?string $mngr_district1__c = null;

    /** District Manager [2] */
    public ?string $mngr_district2__c = null;

    /** Country Manager */
    public ?string $mngr_country__c = null;

    /** Agency Leader */
    public ?string $mngr_leader__c = null;

    /** Director */
    public ?string $mngr_Director__c = null;

    /** Global Group (N0) */
    public ?string $Global_Group_n0__c = null;

    /** IATAS N2 */
    public ?string $IATAS_N2_h__c = null;

    /** SD Contract Administrator */
    public ?string $ASD_Contract_Administrator__c = null;

    /** Contract start date */
    public ?string $Contract_start_date__c = null;

    /** Contract end date */
    public ?string $Contract_end_date__c = null;

    /** Access Code */
    public ?string $Access_Code__c = null;

    /** SD Admin. Region */
    public ?string $Admin_Region_SD__c = null;

    /** CAVR language */
    public ?string $Idioma_CAVR__c = null;

    /** Agency Folio */
    public ?string $Agency_Folio__c = null;

    /** Q3 */
    public ?string $Q3__c = null;

    /** ASD Manager */
    public ?string $ASD_Manager__c = null;

    /** Sales Monitor */
    public ?string $Sales_Monitor__c = null;

    /** PSD leader */
    public ?string $PSD_leader__c = null;

    /** PSD Coordinator */
    public ?string $PSD_Coordinator__c = null;

    /** Q4 */
    public ?string $Q4__c = null;

    /** Account Type 2020 */
    public ?string $Account_Type_2020__c = null;

    /** Región CR */
    public ?string $Region_CR__c = null;

    /** Local Segmentation */
    public ?string $Local_Segmentation__c = null;

    /** Negotiation */
    public ?string $Negotiation__c = null;

    /** Agency Management */
    public ?string $Agency_Management__c = null;

    /** Cuenta Principal N0 */
    public ?string $Cuenta_Principal_NG__c = null;

    /** Cuenta Principal N0 */
    public ?string $Cuenta_Principal_NG2__c = null;

    /** Región GSS */
    public ?string $Region_GSS__c = null;

    /** Subregión GSS */
    public ?string $Subregion_GSS__c = null;

    /** Country */
    public ?string $agy_country__c = null;

    /** Additional comments */
    public ?string $Additional_comments__c = null;

    /** Agency Current CER */
    public ?float $Agency_Current_CER__c = null;

    /** Agency Expected CER */
    public ?float $Agency_Expected_CER__c = null;

    /** Agency Validation Status */
    public ?string $Agency_Validation_Status__c = null;

    /** Corporate Sales Development */
    public ?string $Corporate_Sales_Development__c = null;

    /** Country Current CER */
    public ?float $Country_Current_CER__c = null;

    /** Country Expected CER */
    public ?float $Country_Expected_CER__c = null;

    /** Current Flown Revenue */
    public ?float $Current_Flown_Revenue__c = null;

    /** Current Market Share */
    public ?float $Current_Market_Share__c = null;

    /** Current Premium Product Mix */
    public ?float $Current_Premium_Product_Mix__c = null;

    /** Current Sold Revenue */
    public ?float $Current_Sold_Revenue__c = null;

    /** DL GAM */
    public ?string $DL_GAM__c = null;

    /** DL SD Analyst */
    public ?string $DL_SD_Analyst__c = null;

    /** DL Seller */
    public ?string $DL_Seller__c = null;

    /** Expectect Premium Product Mix */
    public ?float $Expectect_Premium_Product_Mix__c = null;

    /** Expectect Sold Revenue */
    public ?float $Expectect_Sold_Revenue__c = null;

    /** Expected Flown Revenue */
    public ?float $Expected_Flown_Revenue__c = null;

    /** Expected Market Share */
    public ?float $Expected_Market_Share__c = null;

    /** GAM */
    public ?string $GAM__c = null;

    /** MNA Account Manager */
    public ?string $MNA_Account_Manager__c = null;

    /** Negotiation Program name */
    public ?string $Negotiation_Program_name__c = null;

    /** Premium Classes */
    public ?string $Premium_Classes__c = null;

    /** Supplier number */
    public ?string $Supplier_number__c = null;

    /** AM Business */
    public ?string $AM_Business__c = null;

    /** Tracker */
    public ?string $Tracker__c = null;

    /** Domains Allows */
    public ?string $DomainAllows__c = null;

    /** Generic Domains */
    public ?string $AMBiz_Generic_Domain__c = null;

    /** First Name */
    public ?string $AMBiz_Fist_Name__c = null;

    /** Last name */
    public ?string $AMBiz_Last_name__c = null;

    /** User Email */
    public ?string $AmBiz_Email__c = null;

    /** subsegmentation */
    public ?string $subsegmentation__c = null;

    /** Aviso Trade Site Ingles */
    public ?string $Aviso_Trade_Site_en__c = null;

    /** Subdirector Global */
    public ?string $SUBDIRECTOR_GLOBAL__c = null;

    /** Service IATA´s */
    public ?string $Service_IATA_s__c = null;

    /** Ancilaries Disponible Q2 */
    public ?float $Ancilaries_Disponible_Q2__c = null;

    /** Ancilaries Disponible Q3 */
    public ?float $Ancilaries_Disponible_Q3__c = null;

    /** Ancilaries Disponible Q4 */
    public ?float $Ancilaries_Disponible_Q4__c = null;

    /** Ancilaries Q1 */
    public ?float $Ancilaries_Q1__c = null;

    /** Ancilaries Q2 */
    public ?float $Ancilaries_Q2__c = null;

    /** Ancilaries Q3 */
    public ?float $Ancilaries_Q3__c = null;

    /** Ancilaries Q4 */
    public ?float $Ancilaries_Q4__c = null;

    /** Ancilaries Usado Q1 */
    public ?float $Ancilaries_Usado_Q1__c = null;

    /** Ancilaries Usado Q2 */
    public ?float $Ancilaries_Usado_Q2__c = null;

    /** Ancilaries Usado Q3 */
    public ?float $Ancilaries_Usado_Q3__c = null;

    /** Ancilaries Usado Q4 */
    public ?float $Ancilaries_Usado_Q4__c = null;

    /** Monto Q1 */
    public ?float $Monto_Currency_Q1__c = null;

    /** Monto Q2 */
    public ?float $Monto_Currency_Q2__c = null;

    /** Monto Q3 */
    public ?float $Monto_Currency_Q3__c = null;

    /** Monto Q4 */
    public ?float $Monto_Currency_Q4__c = null;

    /** Monto Disponible Q1 */
    public ?float $Monto_Disponible_Q1__c = null;

    /** Monto Disponible Q2 */
    public ?float $Monto_Disponible_Q2__c = null;

    /** Monto Disponible Q3 */
    public ?float $Monto_Disponible_Q3__c = null;

    /** Monto Disponible Q4 */
    public ?float $Monto_Disponible_Q4__c = null;

    /** Monto Usado Q1 */
    public ?float $Monto_Usado_Q1__c = null;

    /** Monto Usado Q2 */
    public ?float $Monto_Usado_Q2__c = null;

    /** Monto Usado Q3 */
    public ?float $Monto_Usado_Q3__c = null;

    /** Monto Usado Q4 */
    public ?float $Monto_Usado_Q4__c = null;

    /** Non Ancilaries Disponible Q1 */
    public ?float $Non_Ancilaries_Disponible_Q1__c = null;

    /** Non Ancilaries Disponible Q2 */
    public ?float $Non_Ancilaries_Disponible_Q2__c = null;

    /** Non Ancilaries Disponible Q3 */
    public ?float $Non_Ancilaries_Disponible_Q3__c = null;

    /** Non Ancilaries Disponible Q4 */
    public ?float $Non_Ancilaries_Disponible_Q4__c = null;

    /** Non Ancilaries Q1 */
    public ?float $Non_Ancilaries_Q1__c = null;

    /** Non Ancilaries Q2 */
    public ?float $Non_Ancilaries_Q2__c = null;

    /** Non Ancilaries Q3 */
    public ?float $Non_Ancilaries_Q3__c = null;

    /** Non Ancilaries Q4 */
    public ?float $Non_Ancilaries_Q4__c = null;

    /** Non Ancilaries Usado Q1 */
    public ?float $Non_Ancilaries_Usado_Q1__c = null;

    /** Non Ancilaries Usado Q2 */
    public ?float $Non_Ancilaries_Usado_Q2__c = null;

    /** Non Ancilaries Usado Q3 */
    public ?float $Non_Ancilaries_Usado_Q3__c = null;

    /** Non Ancilaries Usado Q4 */
    public ?float $Non_Ancilaries_Usado_Q4__c = null;

    /** TradeSite Resources Link */
    public ?string $TradeSite_Resources_Link__c = null;

    /** Security Group */
    public ?string $Security_Group__c = null;

    /** Clave Waivers */
    public ?string $PIN_Agencia__c = null;

    /** Tipo de grupo */
    public ?string $Tipo_de_grupo__c = null;

    /** Código */
    public ?string $Codigo__c = null;
}
