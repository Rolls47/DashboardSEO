<?php

namespace App\Controller\Admin;

use App\Entity\DomainName;
use App\Entity\Sale;
use App\Entity\Customer;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin", name="admin_")
 */
class DashboardController extends AbstractDashboardController
{

    /**
     * @Route("/admin", name="home")
     * @param EntityManagerInterface $em
     * @return Response
     */
    public function mainDash(EntityManagerInterface $em): Response
    {
        // Repository
        $sale = $em->getRepository('App:Sale');
        $dName = $em->getRepository('App:DomainName');
        $customer = $em->getRepository('App:Customer');


// Données pour Chart JS sumPerDnName
        $allSaleDnames = $sale->sumByDomain();
        $dNameName = [];
        $dNameColor = [];
        $dNamePrice = [];

        foreach ($allSaleDnames as $allSaleDname){
            $dNameName[] = $allSaleDname['name'];
            $dNameColor[] = $allSaleDname['color'];
            $dNamePrice[] = $allSaleDname['price'];
        }

// Données pour Chart JS sumPerCustomer
        $intermediates = $sale->sumByIntermediate();
        $categNom   = [];
        $categColor = [];
        $categPrice = [];

        foreach ( $intermediates as $intermediate){
            $categNom[]   = $intermediate['name'];
            $categColor[] = $intermediate['color'];
            $categPrice[] = $intermediate['price'];
        }

// Données pour Chart JS sumPerUser
        $countByUsers  = $sale->sumByUser();
            $userName  = [];
            $userColor =[];
            $userPrice = [];

            foreach ($countByUsers as $countByUser){
                $userName[]  = $countByUser['pseudo'];
                $userColor[] = $countByUser['color'];
                $userPrice[] = $countByUser['price'];
            }

        $allDomain = $dName->findAll();
        $sumByNdd  = $sale->sumByDomain();

        return $this->render('bundles/EasyAdminBundle/welcome.html.twig', [
            'allSales'   => $sale->sumSales()[1],
            'countNdd'   => count($allDomain),
            'sumByNdds'  => $sumByNdd,
            // Données pour Chart JS sumPerCustomer
            'categNom'   => json_encode($categNom),
            'categColor' => json_encode($categColor),
            'categPrice' => json_encode($categPrice),
            // Données pour Chart JS sumPerDnName
            'dNameName'  => json_encode($dNameName),
            'dNameColor' => json_encode($dNameColor),
            'dNamePrice' => json_encode($dNamePrice),
            // Données pour Chart JS sumPerUser
            'userName'   => json_encode($userName),
            'userColor'  => json_encode($userColor),
            'userPrice'  => json_encode($userPrice),

        ]);
    }

    /**
     * @Route("/hellsaya", name="hellsaya")
     * @param EntityManagerInterface $em
     * @return Response
     */
    public function hellsaya(EntityManagerInterface $em): Response
    {
        // Repository
        $sale = $em->getRepository('App:Sale');
        $user = $em->getRepository('App:User');

        //ChartJS
        $sumByHellsaya = $sale->sumDnameHellsaya();

        $hellsayaDname = [];
        $colorDname = [];
        $sumDname   = [];

        foreach ($sumByHellsaya as $data){
            $hellsayaDname[] = $data['name'];
            $colorDname[] = $data['color'];
            $sumDname[]   = $data['price'];
        }

        $sumCustomerhellsaya = $sale->sumCustomerHellsaya();

        $hellsayaCustomer = [];
        $colorCustomer = [];
        $sumCustomer   = [];

        foreach ($sumCustomerhellsaya as $data){
            $hellsayaCustomer[] = $data['name'];
            $colorCustomer[] = $data['color'];
            $sumCustomer[]   = $data['price'];
        }

        $ndd = $user->find(2)->getDomainNames()->toArray($user);
        $nbNdd = count($ndd);
        $sumSales = $sale->userSumSales($user->find(2));
        $sumSales = implode($sumSales);

        return $this->render('dashboard/hellsaya.html.twig', [
            'count' => $nbNdd,
            'sum'   => $sumSales,
            'hellsayaDname' => json_encode($hellsayaDname),
            'colorDname' => json_encode($colorDname),
            'sumDname'   => json_encode($sumDname),
            // sum By Customer
            'hellsayaCustomer' => json_encode($hellsayaCustomer),
            'colorCustomer' => json_encode($colorCustomer),
            'sumCustomer'   => json_encode($sumCustomer),
        ]);
    }

    /**
     * @Route("/orta", name="orta")
     * @param EntityManagerInterface $em
     * @return Response
     */
    public function orta(EntityManagerInterface $em): Response
    {
        // Repository
        $user = $em->getRepository('App:User');
        $sale = $em->getRepository('App:Sale');

        //ChartJS
        $sumByOrta = $sale->sumDnameOrta();

        $ortaDname = [];
        $colorDname = [];
        $sumDname   = [];

        foreach ($sumByOrta as $data){
            $ortaDname[] = $data['name'];
            $colorDname[] = $data['color'];
            $sumDname[]   = $data['price'];
        }

        $sumCustomerOrta = $sale->sumCustomerOrta();

        $ortaCustomer = [];
        $colorCustomer = [];
        $sumCustomer   = [];

        foreach ($sumCustomerOrta as $data){
            $ortaCustomer[] = $data['name'];
            $colorCustomer[] = $data['color'];
            $sumCustomer[]   = $data['price'];
        }

        $ndd = $user->find(3)->getDomainNames()->toArray($user);
        $nbNdd = count($ndd);
        $sumSales = $sale->userSumSales($user->find(3));
        $sumSales = implode($sumSales);

        return $this->render('dashboard/orta.html.twig', [
            'count' => $nbNdd,
            'sum'   => $sumSales,
            'ortaDname' => json_encode($ortaDname),
            'colorDname' => json_encode($colorDname),
            'sumDname'   => json_encode($sumDname),
            // sum By Customer
            'ortaCustomer' => json_encode($ortaCustomer),
            'colorCustomer' => json_encode($colorCustomer),
            'sumCustomer'   => json_encode($sumCustomer),
        ]);
    }

    /**
     * @Route("/rolls", name="rolls")
     * @param EntityManagerInterface $em
     * @return Response
     */
    public function rolls(EntityManagerInterface $em): Response
    {
        // Repository
        $user = $em->getRepository('App:User');
        $sale = $em->getRepository('App:Sale');

        //ChartJS
        $sumByRolls = $sale->sumDnameRolls();

        $rollsDname = [];
        $colorDname = [];
        $sumDname   = [];

        foreach ($sumByRolls as $data){
            $rollsDname[] = $data['name'];
            $colorDname[] = $data['color'];
            $sumDname[]   = $data['price'];
        }

        $sumCustomerRolls = $sale->sumCustomerRolls();

        $rollsCustomer = [];
        $colorCustomer = [];
        $sumCustomer   = [];

        foreach ($sumCustomerRolls as $data){
            $rollsCustomer[] = $data['name'];
            $colorCustomer[] = $data['color'];
            $sumCustomer[]   = $data['price'];
        }

        $ndd = $user->find(1)->getDomainNames()->toArray($user);
        $nbNdd = count($ndd);
        $sumSales = $sale->userSumSales($user->find(1));
        $sumSales = implode($sumSales);

        return $this->render('dashboard/rolls.html.twig', [
            'count'         => $nbNdd,
            'sum'           => $sumSales,
            'rollsDname'    => json_encode($rollsDname),
            'colorDname'    => json_encode($colorDname),
            'sumDname'      => json_encode($sumDname),
            // sum By Customer
            'rollsCustomer' => json_encode($rollsCustomer),
            'colorCustomer' => json_encode($colorCustomer),
            'sumCustomer'   => json_encode($sumCustomer),
        ]);
    }


    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Dashboard SEO');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linktoRoute('Dashboard', 'fa fa-home', 'admin_home');
        yield MenuItem::section('Dashboard User');
        yield MenuItem::linktoRoute('Hellsaya', 'fas fa-cat', 'admin_hellsaya');
        yield MenuItem::linkToRoute('Orta', 'fas fa-crow', 'admin_orta');
        yield MenuItem::linkToRoute('Rolls', 'fas fa-ghost', 'admin_rolls');


        yield MenuItem::section('CRUD');
        yield MenuItem::linkToCrud('Intermédiaires', 'fas fa-building', Customer::class);
        yield MenuItem::linkToCrud('Domain Name', 'fas fa-globe', DomainName::class);
        yield MenuItem::linkToCrud('Utilisateurs', 'fas fa-poo', User::class);
        yield MenuItem::linkToCrud('Ventes', 'fas fa-euro-sign', Sale::class);
        // yield MenuItem::linkToCrud('The Label', 'icon class', EntityClass::class);
    }
}
