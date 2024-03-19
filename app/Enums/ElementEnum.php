<?php

namespace App\Enums;

use App\Enums\MetaProperties\Atomic\{Number, Name};
use ArchTech\Enums\Meta\Meta;
use ArchTech\Enums\Metadata;
use ArchTech\Enums\Options;

#[Meta(Name::class, Number::class)]
enum ElementEnum: string
{
    use Options, Metadata;

    #[Name('Placeholder')] #[Number('0')]
    case X = 'X';

    #[Name('Hydrogen')] #[Number('1')]
    case H  = 'H';

    #[Name('Helium')] #[Number('2')]
    case HE = 'He';

    #[Name('Lithium')] #[Number('3')]
    case LI = 'Li';

    #[Name('Beryllium')] #[Number('4')]
    case BE = 'Be';

    #[Name('Boron')] #[Number('5')]
    case B  = 'B';

    #[Name('Carbon')] #[Number('6')]
    case C  = 'C';

    #[Name('Nitrogen')] #[Number('7')]
    case N  = 'N';

    #[Name('Oxygen')] #[Number('8')]
    case O  = 'O';

    #[Name('Fluorine')] #[Number('9')]
    case F  = 'F';

    #[Name('Neon')] #[Number('10')]
    case NE = 'Ne';

    #[Name('Sodium')] #[Number('11')]
    case NA = 'Na';

    #[Name('Magnesium')] #[Number('12')]
    case MG = 'Mg';

    #[Name('Aluminium')] #[Number('13')]
    case AL = 'Al';

    #[Name('Silicon')] #[Number('14')]
    case SI = 'Si';

    #[Name('Phosphorus')] #[Number('15')]
    case P  = 'P';

    #[Name('Sulfur')] #[Number('16')]
    case S  = 'S';

    #[Name('Chlorine')] #[Number('17')]
    case CL = 'Cl';

    #[Name('Argon')] #[Number('18')]
    case AR = 'Ar';

    #[Name('Potassium')] #[Number('19')]
    case K  = 'K';

    #[Name('Calcium')] #[Number('20')]
    case CA = 'Ca';

    #[Name('Scandium')] #[Number('21')]
    case SC = 'Sc';

    #[Name('Titanium')] #[Number('22')]
    case TI = 'Ti';

    #[Name('Vanadium')] #[Number('23')]
    case V  = 'V';

    #[Name('Chromium')] #[Number('24')]
    case CR = 'Cr';

    #[Name('Manganese')] #[Number('25')]
    case MN = 'Mn';

    #[Name('Iron')] #[Number('26')]
    case FE = 'Fe';

    #[Name('Cobalt')] #[Number('27')]
    case CO = 'Co';

    #[Name('Nickel')] #[Number('28')]
    case NI = 'Ni';

    #[Name('Copper')] #[Number('29')]
    case CU = 'Cu';

    #[Name('Zinc')] #[Number('30')]
    case ZN = 'Zn';

    #[Name('Gallium')] #[Number('31')]
    case GA = 'Ga';

    #[Name('Germanium')] #[Number('32')]
    case GE = 'Ge';

    #[Name('Arsenic')] #[Number('33')]
    case AS = 'As';

    #[Name('Selenium')] #[Number('34')]
    case SE = 'Se';

    #[Name('Bromine')] #[Number('35')]
    case BR = 'Br';

    #[Name('Krypton')] #[Number('36')]
    case KR = 'Kr';

    #[Name('Rubidium')] #[Number('37')]
    case RB = 'Rb';

    #[Name('Strontium')] #[Number('38')]
    case SR = 'Sr';

    #[Name('Yttrium')] #[Number('39')]
    case Y  = 'Y';

    #[Name('Zirconium')] #[Number('40')]
    case ZR = 'Zr';

    #[Name('Niobium')] #[Number('41')]
    case NB = 'Nb';

    #[Name('Molybdenum')] #[Number('42')]
    case MO = 'Mo';

    #[Name('Technetium')] #[Number('43')]
    case TC = 'Tc';

    #[Name('Ruthenium')] #[Number('44')]
    case RU = 'Ru';

    #[Name('Rhodium')] #[Number('45')]
    case RH = 'Rh';

    #[Name('Palladium')] #[Number('46')]
    case PD = 'Pd';

    #[Name('Silver')] #[Number('47')]
    case AG = 'Ag';

    #[Name('Cadmium')] #[Number('48')]
    case CD = 'Cd';

    #[Name('Indium')] #[Number('49')]
    case IN = 'In';

    #[Name('Tin')] #[Number('50')]
    case SN = 'Sn';

    #[Name('Antimony')] #[Number('51')]
    case SB = 'Sb';

    #[Name('Tellurium')] #[Number('52')]
    case TE = 'Te';

    #[Name('Iodine')] #[Number('53')]
    case I  = 'I';

    #[Name('Xenon')] #[Number('54')]
    case XE = 'Xe';

    #[Name('Caesium')] #[Number('55')]
    case CS = 'Cs';

    #[Name('Barium')] #[Number('56')]
    case BA = 'Ba';

    #[Name('Lanthanum')] #[Number('57')]
    case LA = 'La';

    #[Name('Cerium')] #[Number('58')]
    case CE = 'Ce';

    #[Name('Praseodymium')] #[Number('59')]
    case PR = 'Pr';

    #[Name('Neodymium')] #[Number('60')]
    case ND = 'Nd';

    #[Name('Promethium')] #[Number('61')]
    case PM = 'Pm';

    #[Name('Samarium')] #[Number('62')]
    case SM = 'Sm';

    #[Name('Europium')] #[Number('63')]
    case EU = 'Eu';

    #[Name('Gadolinium')] #[Number('64')]
    case GD = 'Gd';

    #[Name('Terbium')] #[Number('65')]
    case TB = 'Tb';

    #[Name('Dysprosium')] #[Number('66')]
    case DY = 'Dy';

    #[Name('Holmium')] #[Number('67')]
    case HO = 'Ho';

    #[Name('Erbium')] #[Number('68')]
    case ER = 'Er';

    #[Name('Thulium')] #[Number('69')]
    case TM = 'Tm';

    #[Name('Ytterbium')] #[Number('70')]
    case YB = 'Yb';

    #[Name('Lutetium')] #[Number('71')]
    case LU = 'Lu';

    #[Name('Hafnium')] #[Number('72')]
    case HF = 'Hf';

    #[Name('Tantalum')] #[Number('73')]
    case TA = 'Ta';

    #[Name('Tungsten')] #[Number('74')]
    case W  = 'W';

    #[Name('Rhenium')] #[Number('75')]
    case RE = 'Re';

    #[Name('Osmium')] #[Number('76')]
    case OS = 'Os';

    #[Name('Iridium')] #[Number('77')]
    case IR = 'Ir';

    #[Name('Platinum')] #[Number('78')]
    case PT = 'Pt';

    #[Name('Gold')] #[Number('79')]
    case AU = 'Au';

    #[Name('Mercury')] #[Number('80')]
    case HG = 'Hg';

    #[Name('Thallium')] #[Number('81')]
    case TL = 'Tl';

    #[Name('Lead')] #[Number('82')]
    case PB = 'Pb';

    #[Name('Bismuth')] #[Number('83')]
    case BI = 'Bi';

    #[Name('Polonium')] #[Number('84')]
    case PO = 'Po';

    #[Name('Astatine')] #[Number('85')]
    case AT = 'At';

    #[Name('Radon')] #[Number('86')]
    case RN = 'Rn';

    #[Name('Francium')] #[Number('87')]
    case FR = 'Fr';

    #[Name('Radium')] #[Number('88')]
    case RA = 'Ra';

    #[Name('Actinium')] #[Number('89')]
    case AC = 'Ac';

    #[Name('Thorium')] #[Number('90')]
    case TH = 'Th';

    #[Name('Protactinium')] #[Number('91')]
    case PA = 'Pa';

    #[Name('Uranium')] #[Number('92')]
    case U  = 'U';

    #[Name('Neptunium')] #[Number('93')]
    case NP = 'Np';

    #[Name('Plutonium')] #[Number('94')]
    case PU = 'Pu';

    #[Name('Americium')] #[Number('95')]
    case AM = 'Am';

    #[Name('Curium')] #[Number('96')]
    case CM = 'Cm';

    #[Name('Berkelium')] #[Number('97')]
    case BK = 'Bk';

    #[Name('Californium')] #[Number('98')]
    case CF = 'Cf';

    #[Name('Einsteinium')] #[Number('99')]
    case ES = 'Es';

    #[Name('Fermium')] #[Number('100')]
    case FM = 'Fm';

    #[Name('Mendelevium')] #[Number('101')]
    case MD = 'Md';

    #[Name('Nobelium')] #[Number('102')]
    case NO = 'No';

    #[Name('Lawrencium')] #[Number('103')]
    case LR = 'Lr';

    #[Name('Rutherfordium')] #[Number('104')]
    case RF = 'Rf';

    #[Name('Dubnium')] #[Number('105')]
    case DB = 'Db';

    #[Name('Seaborgium')] #[Number('106')]
    case SG = 'Sg';

    #[Name('Bohrium')] #[Number('107')]
    case BH = 'Bh';

    #[Name('Hassium')] #[Number('108')]
    case HS = 'Hs';

    #[Name('Meitnerium')] #[Number('109')]
    case MT = 'Mt';

    #[Name('Darmstadtium')] #[Number('110')]
    case DS = 'Ds';

    #[Name('Roentgenium')] #[Number('111')]
    case RG = 'Rg';

    #[Name('Copernicium')] #[Number('112')]
    case CN = 'Cn';

    #[Name('Nihonium')] #[Number('113')]
    case NH = 'Nh';

    #[Name('Flerovium')] #[Number('114')]
    case FL = 'Fl';

    #[Name('Moscovium')] #[Number('115')]
    case MC = 'Mc';

    #[Name('Livermorium')] #[Number('116')]
    case LV = 'Lv';

    #[Name('Tennessine')] #[Number('117')]
    case TS = 'Ts';

    #[Name('Oganesson')] #[Number('118')]
    case OG = 'Og';
}
